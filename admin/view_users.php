<?php
$page = 'View Users';
include 'header.php';

// Define a whitelist of allowed parameters
$allowed_params = ['username', 'email', 'role', 'status'];

// Get any conditions from the GET parameters
$conditions = [];
$conn = connect();
foreach ($_GET as $key => $value) {
    if (in_array($key, $allowed_params)) {
        $conditions[] = $key . " = '" . mysqli_real_escape_string($conn, $value) . "'";
    }
}

// Create WHERE clause if there are any conditions
$where_clause = '';
if (!empty($conditions)) {
    $where_clause = ' WHERE ' . implode(' AND ', $conditions);
}

$users = select_rows('SELECT * FROM users' . $where_clause);
?>
<div class="content-wrapper">
    <div class="container">
        <h3 class="p3">All Users</h3>
        <section class="connectedSortable ui-sortable">
            <div class="card card-indigo">
                <div>
                    <a class="btn btn-primary m-1" style="float: right; background-color: #1B2815;" href="add_user.php">Add A User</a>
                </div>
                <div class="card-header" style="background-color: #1B2815;">
                    <h3 class="card-title" style="color: white">
                        View All users</h3>
                </div>

                <div class="card-body">
                    <table id="view_users" class="table">
                        <thead>
                            <tr>
                                <th>count</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Comments</th>
                                <th>Created At</th>
                                <th>Updated at</th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <?php
                        $cnt = 1;
                        foreach ($users as $user) {
                            $id = $user['id'];
                        ?>
                            <tr>
                                <td>
                                    <?= $cnt ?>
                                </td>
                                <td>
                                    <?= $user['full_name'] ?>
                                </td>
                                <td>
                                    <?= $user['email'] ?>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#statusChangeModal<?= $id ?>" class="btn btn-primary p-1">
                                        <?= $user['status'] ?> </a>
                                    <div class="modal fade" id="statusChangeModal<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="statusChangeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="statusChangeModalLabel">Change Status</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="includes/status_change.php">
                                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                        <div class="form-group">
                                                            <label for="approval_status">Select Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="active" <?= ($user['status'] == 'active') ? 'selected' : '' ?>>Active
                                                                </option>
                                                                <option value="inactive" <?= ($user['status'] == 'inactive') ? 'selected' : '' ?>>Inactive
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="comment">Add A Comment</label>
                                                            <textarea name="comments" id="comment" cols="30" rows="4" class="form-control">
                                                            <?= $user['comments'] ?>
                                                        </textarea>
                                                        </div>
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?= $user['role'] ?>
                                </td>
                                <td>
                                    <?= $user['status'] ?>
                                </td>
                                <td>
                                    <?= date('l jS Y, g:ia', strtotime($user['date_created'])) ?>
                                </td>
                                <td>
                                    <?= date('l jS Y, g:ia', strtotime($user['updated_at'])) ?>
                                </td>
                                <td>
                                    <a class="btn btn-primary p-1" href="add_user.php?id=<?= $user['id'] ?>">Edit</a>
                                    <a href="<?= admin_url; ?>delete<?= '&id=' . $user['id'] . '&table=users&page=view_users.php' ?>" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php $cnt++;
                        } ?>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

<script>
    $("#view_users").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
</script>
<?php include "includes/footer.php"; ?>