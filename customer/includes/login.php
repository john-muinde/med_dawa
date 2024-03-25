<?php
include 'connect.php';
$success = "";
$unsuccess = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($DB, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            // check password
            //get password in db
            $row = mysqli_fetch_assoc($result);
            $password_hash = $row['password'];
            //compare password from user with the hash in the db
            if (password_verify($password, $password_hash)) {
                $success = "Login successful";
            } else {
                $unsuccess = "Login failed";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedDawa Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            max-width: 100%;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .switch-form {
            margin-top: 15px;
        }

        .switch-form a {
            text-decoration: none;
            color: #4caf50;
        }

        .switch-form a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form action="" method="post">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <?php
        if (!empty($success)) {
            echo "<div class='error'>$success</div>";
            //start a user session
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $row['id'];
            header('Location: ../index.php');
        }
        if (!empty($unsuccess)) {
            echo "<div class='error'>$unsuccess</div>";
        }
        ?>

        <div class="switch-form">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>

</html>