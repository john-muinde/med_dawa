<?php

session_start();

// Check if the user is already logged in
if (isset($_SESSION["id"])) {
    // User is already logged in, redirect to the dashboard or desired page
    redirect("dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MEDDAWA | Log in (v2)</title>

    <style>
        body {
            background-image: url("assets/images/login_background.jpg");
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container-fluid {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            color: chocolate;
        }

        label {
            color: orange;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid blue;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button[type="button"],
        input[type="submit"] {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="button"]:hover,
        input[type="submit"]:hover {
            background-color: navy;
        }

        .document-row {
            margin-bottom: 10px;
        }

        .form-section {
            display: none;
        }

        .form-section.current {
            display: block;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .pagination button {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .pagination button:hover {
            background-color: navy;

        }



        @media screen and (max-width: 768px) {

            /* Adjust styles for screens up to 768px width */
            body {
                background-size: auto;
                height: auto;
            }

            .container-fluid {
                padding: 10px;
                border-radius: 0;
                box-shadow: none;
                max-width: none;
            }
        }

        @media screen and (max-width: 576px) {

            /* Adjust styles for screens up to 576px width */
            .row {
                flex-direction: column;
            }

            .col-md-6 {
                width: 100%;
            }
        }
    </style>
    <?php include "includes/meta.php"; ?>
</head>

<body class="hold-transition login-page">
    <div class="container-fluid">
        <div class="card-header text-center">
            <a href="index.php">
                <img src="logo.png" alt="MEDDAWA" class="h1" style="max-width: 100%; max-height: 100px;">
            </a>

        </div>
        <h2 class="text-center">Register Your Account</h2>
        <form action="includes/process_registration.php" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_SESSION['notification'])) {
                $message = $_SESSION['notification']['message'];
                $type = $_SESSION['notification']['type'];
                // Display the notification using Toastr
                echo '<script>window.onload = () => toastr.' . $type . '("' . $message . '"); </script>';
                unset($_SESSION['notification']);
            }
            ?>

            <!-- First row of inputs (two in a row) -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="full_name">Full Name*</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" required>
                </div>
            </div>


            <!-- Single input in a row -->
            <div class="mb-3">
                <label for="email">Email*</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <!-- Single input in a row -->
            <div class="mb-3">
                <label for="password">Password*</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <!-- Single input in a row -->
            <div class="mb-3">
                <label for="confirm_password">Confirm Password*</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>

            <!-- Submit button in a row -->
            <div class="form-group d-flex justify-content-center align-items-center">
                <input type="submit" value="Sign Up" class="btn btn-primary">
            </div>
        </form>
    </div>
    <script>
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        passwordInput.addEventListener('input', validatePassword);

        function validatePassword() {
            const password = passwordInput.value;

            // Validate password strength
            const hasNumber = /[0-9]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasUpperCase = /[A-Z]/.test(password);
            const hasSpecialCharacter = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/.test(password);

            if (password.length >= 8 && hasNumber && hasLowerCase && hasUpperCase && hasSpecialCharacter) {
                passwordInput.setCustomValidity('');
            } else {
                passwordInput.setCustomValidity(
                    'Password must be at least 8 characters long and contain at least one number, one lowercase letter, one uppercase letter, and one special character.'
                );
            }
        }

        confirmPasswordInput.addEventListener('input', validatePasswordMatch);

        function validatePasswordMatch() {
            if (passwordInput.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity("Passwords don't match.");
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        }
    </script>
    <?php include "includes/scripts.php"; ?>
</body>

</html>