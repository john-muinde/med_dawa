<?php
session_start();
require_once '../operations_model.php';

$redirect_url = "../view_users.php";

// Create a new user instance and set the properties
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = select_rows("SELECT * FROM users WHERE id = '" . $_POST["user_id"] . "'");
    $user = $user[0] ?? null;
    if (!$user) {
        displayNotification("User not found", "error");
        redirect($redirect_url);
    }

    $success = update_row(["status" => $_POST["status"], "comments" => $_POST["status"], "updated_at" => date('Y-m-d H:i:s')], "users", $user['id']);

    if (!$success) {
        displayNotification("An error occurred while updating user status. Please try again later.", "error");
        redirect($redirect_url);
    }
    displayNotification("User status update successful", "success");
    redirect($redirect_url);
}

redirect($redirect_url);
