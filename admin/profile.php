<?php
$page = 'Profile';
include 'header.php';
$user = $_SESSION["user"];
?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row d-flex align-items-center justify-content-center mt-4 mb-0">
                <!-- /.col -->
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills d-flex align-items-center justify-content-center">
                                <li class="nav-item">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="assets/images/avatar.png" alt="User profile picture">
                                    </div>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal" action="includes/updated_profile.php" method="POST">
                                    <?php
                                    echo formGroup("User Id", $user["id"], "id", "text", true, true);
                                    echo formGroup("Full Name", $user["full_name"], "full_name", "text", true, false);
                                    echo formGroup("Email", $user["email"], "email", "email", true, false);
                                    echo formGroup("User Role", $user["role"], "role", "text", true, false);
                                    echo formGroup("Active Status", $user["status"], "status", "text", true, true);

                                    echo formGroup("Created at", $user["date_created"], "date_created", "text", true, true);
                                    echo formGroup("Updated at", $user["updated_at"], "updated_at", "text", true, true);
                                    ?>

                                    <div class="form-group row ">
                                        <div class="offset-sm-2 col-sm-10 d-flex justify-content-center">
                                            <button type="submit" class="btn btn-danger">Update Details</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>
<?php include "includes/footer.php"; ?>