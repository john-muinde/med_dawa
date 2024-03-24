<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (isset($_SESSION["user"])) {
  header("Location:dashboard.php");
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
      background-image: url("./assets/images/login_background.jpg");
      background-size: cover;
      background-position: center;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    /* Add CSS for warning text */
    .warning-text {
      background-color: #FFA500;
      color: #FFFFFF;
      padding: 10px;
      text-align: center;
      font-weight: bold;
    }
  </style>

  <?php include "includes/meta.php";
  if (isset($_SESSION['notification'])) {
    $message = $_SESSION['notification']['message'];
    $type = $_SESSION['notification']['type'];

    echo '<script>
    window.onload = () => toastr.
    ' . $type . '("' . $message . '");
  </script>';

    unset($_SESSION['notification']);
  }
  if (isset($_SESSION['user'])) {
  }
  ?>
</head>

<body class="hold-transition login-page">
  <!-- Add the warning text here -->
  <div class="warning-text">
    WARNING: Only authorized users should proceed.
  </div>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">

      <div class="card-header text-center">
        <a href="index.php">
          <img src="LOGO.PNG" alt="MEDDAWA" class="h1" style="max-width: 100%; max-height: 100px;">
        </a>

      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="includes/login_inc.php" method="post">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="password-field" placeholder="Password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text">

                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" </span>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="icheck-primary d-flex flex-row ">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember for 30 days
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-12 d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
        </form>
        <p class="mb-0">
          <a href="registration.php" class="text-center">Register a new membership</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
  <!-- Your other custom scripts -->
  <script>
    $(".toggle-password").click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  </script>
  <?php include "includes/scripts.php"; ?>
</body>

</html>