<?php
$page = 'View Products';
include 'header.php';

// Define a whitelist of allowed parameters
$allowed_params = ['product_name', 'product_price', 'category_id', 'product_in_stock', 'product_quantity'];

// Get any conditions from the GET parameters
$conditions = [];
$conn = connect();
foreach ($_GET as $key => $value) {
    if (in_array($key, $allowed_params)) {
        if ($key == 'product_quantity') {
            $conditions[] = $key . " <= 10";
        } else {
            $conditions[] = $key . " = '" . mysqli_real_escape_string($conn, $value) . "'";
        }
    }
}

// Create WHERE clause if there are any conditions
$where_clause = '';
if (!empty($conditions)) {
    $where_clause = ' WHERE ' . implode(' AND ', $conditions);
}

$categories = select_rows('SELECT * FROM category');
$products = select_rows('SELECT * FROM product' . $where_clause);

?>
<div class="content-wrapper">
    <div class="container">
        <h3 class="p3">Products</h3>
        <section class="connectedSortable">
            <div class="card card-indigo">
                <div>
                    <a class="btn btn-primary m-1" style="float: right;" href="add_product.php">Add A Product</a>
                </div>
                <div class="card-header">
                    <h3 class="card-title">View Products</h3>
                </div>
                <div class="card-body">
                    <table class="table" id="view_products">
                        <thead>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Offer Price</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Qty</th>

                            <th>Created On</th>
                            <th>Action</th>
                        </thead>
                        <?php
                        $cnt = 1;
                        foreach ($products as $product) {
                            $product_id         = $product['id'];
                            $category_name      = select_rows("SELECT category_name FROM category WHERE id = '" . $product['category_id'] . "'")[0]['category_name'] ?? "No category";
                        ?>
                            <tr>
                                <td><?= $cnt ?></td>
                                <td>
                                    <img alt="product image <?= $product['product_name'] ?>" src="<?= file_url . $product['product_image'] ?>" style="width:150px; height:auto; border-radius:5px;" title="<?= $product['product_name'] ?>">
                                </td>
                                <td><?= $product['product_name'] ?></td>
                                <td><?= $product['product_price'] ?></td>
                                <td><?= $product['product_offer_price'] ?></td>

                                <td><?= $category_name ?></td>
                                <td><?= $subcategory_name ?></td>
                                <td><?= $product['product_quantity'] ?></td>

                                <td><?= date('d-m-Y h:i:sa', strtotime($product['product_date_created'])) ?></td>
                                <td>
                                    <a href="add_product.php?id=<?= $product_id ?>" class="btn btn-success">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="<?= admin_url; ?>delete<?= '&id=' . $product_id . '&table=product&page=view_products.php' ?>" class="btn btn-danger">
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
    $("#view_products").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
</script>
<?php include 'footer.php'; ?>