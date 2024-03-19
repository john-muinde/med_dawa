<?php
$page = 'Add User';
include 'header.php';
$user = $_SESSION["user"];

isset($_GET['id']) ? $edit = true : $edit = false;
if ($edit) {
    $id = $_GET['id'];
    $editUser = select_rows("SELECT * FROM users WHERE id = '$id'");
    $editUser = $editUser[0] ?? null;
    if (!isset($editUser)) {
        displayNotification("User not found", "error");
        redirect("view_users.php");
    }
}
?>
<div class="content-wrapper">
    <div class="container">
        <h3 class="p3 mt-2">
            Add Users
        </h3>
        <br>
        <section class="connectedSortable">
            <div class="card card-indigo">
                <br>
                <div class="card-header" style="background-color: #1B2815;">
                    <h3 class="card-title" style="color: white">
                        Add Users
                    </h3>
                </div>

                <div class="card-body">

                    <form action="includes/process_registration.php?page=admin" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="admin_id" value="<?= $_SESSION["user"]["id"] ?>">

                        <?php if ($edit) : ?>
                            <div class="form-group">
                                <label for="full_name">User Id</label>
                                <input type="text" name="edit" value="<?= $editUser['id'] ?>" class="form-control" readonly>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $editUser['full_name'] ?? '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $editUser['email'] ?? '' ?>" required>
                        </div>

                        <?php if (!$edit) : ?>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Password</label>
                                <input type="confirm_password" class="form-control" id="confirm_password" name="confirm_password" value="" required>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="role">User Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="admin" <?= $editUser['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="user" <?= $editUser['role'] == 'user' ? 'selected' : '' ?>>User</option>
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </section>
    </div>
</div>