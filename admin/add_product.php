<?php
$page = 'Add Product';
include 'header.php';
$user = $_SESSION["user"];

isset($_GET['id']) ? $edit = true : $edit = false;
if ($edit) {
    $id = $_GET['id'];
    $product = select_rows("SELECT * FROM product WHERE id = '$id'");
    $product = $product[0] ?? null;

    if (!isset($product)) {
        displayNotification("Category not found", "error");
        redirect("view_products.php");
    }
}
?>

<div class="content-wrapper">
    <div class="container">
        <h3 class="p-3">Categories</h3>
        <section class="connectedSortable">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <!-- Category Title -->
                    </h3>
                </div>
                <form method="post" enctype="multipart/form-data" action="<?= admin_url; ?>product<?= $edit ? '&id=' . $id : '' ?>">
                    <div class="row m-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" id="product_name" name="product_name" value="<?= $product['product_name'] ?>" class="form-control" required>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6 form-group">
                            <label for="product_price">Price (price before discount)</label>
                            <input type="number" id="product_price" name="product_price" value="<?= $product['product_price'] ?>" class="form-control" required>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6 form-group">
                            <label for="product_offer_price">New Price (price after discount)</label>
                            <input type="number" id="product_offer_price" name="product_offer_price" value="<?= $product['product_offer_price'] ?>" class="form-control">
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6 form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <?php
                                $categories = select_rows("SELECT * FROM category");
                                foreach ($categories as $category) {
                                    echo "<option value='{$category['id']}'>{$category['category_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6 form-group">
                            <label for="product_in_stock">In Stock?</label>
                            <select id="product_in_stock" name="product_in_stock" class="form-control" required>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6 form-group">
                            <label for="product_quantity">Quantity/Stock</label>
                            <input type="number" id="product_quantity" name="product_quantity" value="<?= $product['product_quantity'] ?>" class="form-control" required>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="product_description">Description</label>
                            <textarea id="product_description" name="product_description" class="form-control" required><?= $product['product_description'] ?></textarea>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                            <label for="product_image">Product Image</label>

                            <input type="file" id="product_image" name="product_image" class="form-control-file" <?= !isset($product['product_image']) || empty($product['product_image']) ? 'required' : '' ?> onchange="previewImage(event)">
                            <div class="text-center">
                                <i>accepted image types are: .png, .jpg, .jpeg</i>
                            </div>
                            <!-- Image Preview -->
                            <div class="form-group d-flex justify-content-center">
                                <img alt="product_image" src="<?= isset($product["product_image"]) && !empty($product["product_image"]) ? file_url . $product["product_image"] :  placeholder ?>" id="img_loader" style="
                                border-radius: 5%;
                                border-color: grey;
                                border-style: solid;
                                height: 30vw;
                                width: 40vw;
                                " />
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center form-group">
                            <input type="submit" value="Submit" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<?php include 'footer.php'; ?>