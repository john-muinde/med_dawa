<?php
$page = 'Add User';
include 'header.php';
$user = $_SESSION["user"];

isset($_GET['id']) ? $edit = true : $edit = false;
if ($edit) {
    $id = $_GET['id'];
    $editingCategory = select_rows("SELECT * FROM category WHERE id = '$id'");
    $editingCategory = $editingCategory[0] ?? null;

    if (!isset($editingCategory)) {
        displayNotification("Category not found", "error");
        redirect("view_categories.php");
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
                        <?= $edit ? "Edit" : "Add" ?> Category
                    </h3>
                </div>
                <form method="post" enctype="multipart/form-data" action="<?= admin_url; ?>category<?= $edit ? '&id=' . $id : ''    ?>">
                    <div class="row clearfix m-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- Name Input -->
                            <div class="form-group">
                                <label for="category_name">Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?= $editingCategory['category_name'] ?>" required />
                            </div>

                            <!-- Description Input -->
                            <div class="form-group">
                                <label for="category_description">Description</label>
                                <textarea class="form-control" id="category_description" name="category_description">
                                    <?= $editingCategory['category_description'] ?>
                                </textarea>
                            </div>

                            <!-- Category Image Input -->
                            <div class="form-group">
                                <label for="category_image">Category Image</label>
                                <input type="file" class="form-control" id="category_image" name="category_image" value="<?= $editingCategory['category_image'] ?>" <?= $edit ? '' : 'required' ?> onchange="previewImage(event)" />
                            </div>

                            <!-- Image Preview -->
                            <div class="form-group d-flex justify-content-center">
                                <img alt="category_image" src="<?= isset($editingCategory["category_image"]) && !empty($editingCategory["category_image"]) ? file_url . $editingCategory["category_image"] :  placeholder ?>" id="img_loader" style="
                                border-radius: 5%;
                                border-color: grey;
                                border-style: solid;
                                height: 30vw;
                                width: 40vw;
                                " />
                            </div>

                            <script>
                                function previewImage(event) {
                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        var output = document.getElementById('img_loader');
                                        output.src = reader.result;
                                    }
                                    reader.readAsDataURL(event.target.files[0]);
                                }
                            </script>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>