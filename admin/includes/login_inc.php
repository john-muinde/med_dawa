<?php
session_start();
require_once '../operations_model.php';

// Check if the user is already logged in
if (isset($_SESSION["user"]) && $_SESSION["user"]["role"] === "admin") {
    // User is already logged in, redirect to the dashboard or desired page
    redirect("../dashboard.php");
}


$redirect_url = "../index.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check Required Fields
    $errors = checkRequiredFields($_POST, ["email", "password"]);

    // Check for errors
    if (!empty($errors)) {
        displayNotification($errors, "error");
        redirect($redirect_url);
    }


    // Retrieve form data
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $rememberMe = isset($_POST["remember_me"]) ? true : false;

    // Check if the user exists
    $user = select_rows("SELECT * FROM users WHERE email = '$email' AND role = 'admin'");
    $user = $user[0] ?? null;


    if (isset($user)) {
        // Verify password using password_verify() function
        $hashedPassword = $user["password"];
        $match = password_verify($password, $hashedPassword);

        if ($match) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION['user'] = $user;

            unset($_SESSION['user']['password']);
            $_SESSION["login_time"] = time();

            displayNotification("Login Successful", "success");
            redirect("../dashboard.php");
        } else {
            displayNotification("Invalid email or password.", "error");
            redirect($redirect_url);
        }
    } else {
        displayNotification("Check Your Credentials or contact your admin", "error");
        redirect($redirect_url);
    }
}
