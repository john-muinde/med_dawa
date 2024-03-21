<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "admin") {

    session_unset();
    session_destroy();
    header("Location: index.php");
}

// Set a timeout (in seconds)
$timeout = 9000;

if (isset($_SESSION["login_time"]) && (int) (time() - $_SESSION["login_time"]) > $timeout) {

    session_unset();
    session_destroy();
    header("Location: index.php");
}
