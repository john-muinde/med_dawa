<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedDawa Registration</title>
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
    <div class="container" method="post">
        <h2>Register</h2>
        <form action="" method="post">
            <label for="username"> Full names</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <button type="submit">Register</button>
        </form>

        <div class="switch-form">
            <p>Already have an account? <a href="login.php">Log in here</a></p>
        </div>
    </div>

    <?php
    //connect to the db
    include 'connect.php';
    // run this code when the user clicks on register
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //pick data user that has been entered
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        //create operation/insert
        $sql  = "INSERT INTO users (full_name, email, password) VALUES('$username', '$email', '$password')";
        //execute query
        $result = mysqli_query($DB, $sql);
        if ($result) {
            echo "Registration successful";
            header("Location: ../index.php");
        } else {
            die(mysqli_error($connect));
        }
    }
    ?>
</body>

</html>