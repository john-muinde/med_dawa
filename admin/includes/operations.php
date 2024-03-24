<?php
session_start();
require_once '../operations_model.php';

$redirect_url = "../view_users.php";

// Create a new user instance and set the properties
if ($_SERVER["REQUEST_METHOD"] === "POST" || ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['action']))) {
    $id = $_GET['id'];
    $editing = isset($_GET['id']) ? true : false;
    $action = $_GET['action'];

    switch ($action) {
        case 'category':
            $category_name = $_POST['category_name'];
            $category_description = $_POST['category_description'];
            $redirect_url = "../view_categories.php";
            $category_image = $_FILES['category_image']['name'];

            // Handle the file upload
            if (!empty($_FILES["category_image"]["name"])) {
                $target_file = '../../uploads/' . basename($_FILES["category_image"]["name"]);
                move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file);
            }

            if ($editing) {
                $editing = select_rows("SELECT * FROM category WHERE id = '$id'");
                $editing = $editing[0] ?? null;

                $errorUrl = "../add_category.php" . "?id=" . $id;

                if (!isset($editing)) {
                    displayNotification("Category not found", "error");
                    redirect($redirect_url);
                }

                $data = [
                    "category_name" => $category_name,
                    "category_description" => $category_description,
                    "admin_id" => $_SESSION['user']['id']
                ];

                if (!empty($category_image)) {
                    $data['category_image'] = $category_image;
                }

                $success = update_row($data, "category",  $id);

                if (!$success) {
                    displayNotification("An error occurred while updating the category. Please try again later.", "error");
                    redirect($errorUrl);
                }

                displayNotification("Category update successful", "success");
                redirect($redirect_url);
            }

            $data = [
                "category_name" => $category_name,
                "category_description" => $category_description,
                "category_image" => $category_image,
                "category_date_created" => date('Y-m-d H:i:s'),
                "admin_id" => $_SESSION['user']['id']
            ];

            $success = insert_rows("category", $data);

            if (!$success) {
                displayNotification("An error occurred while updating the category. Please try again later.", "error");
                redirect($redirect_url);
            }

            displayNotification("Category addition successful", "success");
            redirect($redirect_url);
            break;
        case 'product':
            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_offer_price = $_POST['product_offer_price'];
            $category_id = $_POST['category_id'];
            $product_in_stock = $_POST['product_in_stock'];
            $product_description = $_POST['product_description'];
            $product_quantity = $_POST['product_quantity'];
            $product_image = $_FILES['product_image']['name'];
            $product_date_created = date('Y-m-d H:i:s');
            $redirect_url = "../view_products.php";

            // Handle the file upload
            if (!empty($_FILES["product_image"]["name"])) {
                $target_file = '../../uploads/' . basename($_FILES["product_image"]["name"]);
                move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);
            }

            if ($editing) {
                $editing = select_rows("SELECT * FROM product WHERE id = '$id'");
                $editing = $editing[0] ?? null;

                $errorUrl = "../add_product.php" . "?id=" . $id;

                if (!isset($editing)) {
                    displayNotification("Product not found", "error");
                    redirect($redirect_url);
                }

                $data = [
                    "product_name" => $product_name,
                    "product_price" => $product_price,
                    "product_offer_price" => $product_offer_price,
                    "category_id" => $category_id,
                    "product_in_stock" => $product_in_stock,
                    "product_quantity" => $product_quantity,
                    "product_date_created" => $product_date_created,
                    "admin_id" => $_SESSION['user']['id'],
                    "product_description" => $product_description
                ];

                if (!empty($product_image)) {
                    $data['product_image'] = $product_image;
                }

                $success = update_row($data, "product",  $id);

                if (!$success) {
                    displayNotification("An error occurred while updating the product. Please try again later.", "error");
                    redirect($errorUrl);
                }

                displayNotification("Product update successful", "success");
                redirect($redirect_url);
            }

            $data = [
                "product_name" => $product_name,
                "product_price" => $product_price,
                "product_offer_price" => $product_offer_price,
                "category_id" => $category_id,
                "product_in_stock" => $product_in_stock,
                "product_quantity" => $product_quantity,
                "product_image" => $product_image,
                "product_date_created" => $product_date_created,
                "product_description" => $product_description,
                "admin_id" => $_SESSION['user']['id']
            ];

            $success = insert_rows("product", $data);

            if (!$success) {
                displayNotification("An error occurred while updating the product. Please try again later.", "error");
            }

            displayNotification("Product addition successful", "success");
            redirect($redirect_url);
        case 'delete':
            $id = $_GET['id'];
            $table = $_GET['table'];
            $redirect_url = "../" . $_GET['page'];

            $success = delete_row($table, $id);

            if (!$success) {
                displayNotification("An error occurred while deleting the record. Please try again later.", "error");
                redirect($redirect_url);
            }

            displayNotification("Record deletion successful", "success");
            redirect($redirect_url);
        default:
            displayNotification("Invalid action $action", "error");
            redirect($redirect_url);
    }
}
