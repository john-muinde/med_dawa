<?php
$page = 'View Users';
include 'header.php';

// Define a whitelist of allowed parameters
$allowed_params = ['category_name', 'category_id'];

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

$categories = select_rows('SELECT * FROM category' . $where_clause);
?>
<div class="content-wrapper">
    <div class="container">
        <h3 class="p3">Categories</h3>
        <section class="connectedSortable">
            <div class="card card-indigo">
                <div>
                    <a class="btn btn-primary m-1" style="float: right;" href="add_category.php">Add Category</a>
                </div>
                <div class="card-header">
                    <h3 class="card-title">View Categories</h3>
                </div>
                <div class="card-body">
                    <table class="table" id="view_categories">
                        <thead>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </thead>
                        <?php
                        $cnt = 1;
                        foreach ($categories as $category) {
                            $category_id = $category['id'];
                        ?>
                            <tr>
                                <td><?= $cnt ?></td>
                                <td><?= $category['category_name'] ?></td>
                                <td>
                                    <img alt="property image <?= $category['category_name'] ?>" src="<?= file_url . $category['category_image'] ?>" style="width:150px; height:auto; border-radius:5px;" title="<?= $category['category_name'] ?>">
                                </td>
                                <td><?= $category['category_date_created'] ?></td>
                                <td>
                                    <a href="add_category.php?id=<?= $category_id ?>" class="btn btn-success">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <a href="<?= admin_url; ?>delete<?= '&id=' . $category_id . '&table=category&page=view_categories.php' ?>" class="btn btn-danger">
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
    $("#view_categories").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
</script>
<?php include 'footer.php'; ?>