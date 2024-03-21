<?php

session_start();
require_once '../operations_model.php';

$redirect_url = "../reset_password.php";

$success_url = "../reset_password.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Check Required Fields
    $errors = checkRequiredFields($_POST, ["new_password", "confirm_password", "id", "old_password"]);

    // Check for errors
    if (!empty($errors)) {
        displayNotification($errors, "error");
        redirect($redirect_url);
    }


    $id = $_POST["id"];
    $password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    //Confirm that passwords match
    if ($password !== $confirm_password) {
        displayNotification("Passwords do not match", "error");
        redirect($redirect_url);
    }

    // Check if the user exists
    $user = User::where('id', $id)->first();

    if (isset($user)) {
        // update the given fields
        if (!password_verify($_POST["old_password"], $user->password)) {
            displayNotification("Old Password is not correct", "error");
            redirect($redirect_url);
        }
        $user->password = $user->hashPassword($password);


        if ($user->save()) {
            displayNotification("User Password update Successful", "success");
            redirect($success_url);
        } else {
            displayNotification("Error updating user password", "error");
            redirect($redirect_url);
        }
    } else {
        displayNotification("User does not exist", "error");
        redirect($redirect_url);
    }
} else {
    displayNotification("Invalid Method used", "error");
    redirect($redirect_url);
}