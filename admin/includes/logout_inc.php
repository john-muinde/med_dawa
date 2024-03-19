<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear the remember me cookie
setcookie('remember_me_cookie', '', time() - 3600, '/');

// Redirect to the login page or desired page
header("Location:../index.php");
exit();
