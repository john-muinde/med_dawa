<?php

require_once '../operations_model.php';

// Check if the user is already logged in
if (isset($_SESSION["user"]) && !isset($_GET["page"])) {
    // User is already logged in, redirect to the dashboard or desired page
    redirect("../dashboard.php");
}
$redirect_url = "../registration.php";

if (isset($_GET["page"])) {
    $redirect_url = "../view_users.php";
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST["edit"])) {
        $errors = checkRequiredFields($_POST, ["full_name", "email", "password", "confirm_password"]);
    }
    // Retrieve form data
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);

    // Check for errors
    if (!empty($errors)) {
        displayNotification($errors, "error");
        redirect($redirect_url);
    }
    //Confirm that passwords match
    if (!isset($_POST["edit"])) {
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        if ($password !== $confirm_password) {
            displayNotification("Passwords do not match", "error");
            redirect($redirect_url);
        }
    }


    // Create a new user instance and set the properties
    if (isset($_POST["edit"])) {
        $user = select_rows("SELECT * FROM users WHERE id = " . $_POST["edit"]);
        $user = $user[0] ?? null;
        if (!$user) {
            displayNotification("User not found", "error");
            redirect($redirect_url);
        }

        $success = update_row(["full_name" => $full_name, "email" => $email, "role" => $_POST["role"] ?? "user", "updated_at" => date('Y-m-d H:i:s')], "users", $user['id']);

        if (!$success) {
            displayNotification("An error occurred while registering. Please try again later.", "error");
            redirect($redirect_url);
        }
        displayNotification("User Update successful", "success");
        redirect($redirect_url);
    } else {
        $user = select_rows("SELECT * FROM users WHERE email = '" . $email . "'");
        $user = $user[0] ?? null;

        if (isset($user)) {
            displayNotification("Email already exists", "error");
            redirect($redirect_url);
        }

        $data = [
            "full_name" => $full_name,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "role" => "user",
            "date_created" => date('Y-m-d H:i:s'),
            "updated_at" => null
        ];

        $success = insert_rows("users", $data);

        if (!$success) {
            // The user was not saved, display error message
            displayNotification("An error occurred while registering. Please try again later.", "error");
            redirect($redirect_url);
        }

        // Display a success message and redirect to verification email sent page
        displayNotification("Registration successful. ", "success");

        // Redirect to dashboard or desired page
        redirect('../index.php');
    }
}
