<?php
session_start();
require_once '../operations_model.php';

$redirect_url = "../view_users.php";

// Create a new user instance and set the properties
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_GET['id'];
    $editing = isset($_GET['id']) ? true : false;
    $action = $_GET['action'];

    switch ($action) {
        case 'category':
            $category_name = $_POST['category_name'];
            $category_description = $_POST['category_description'];
            $category_image = $_FILES['category_image']['name'];
            $redirect_url = "../view_categories.php";

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

            $success = insert_rows("category", $data); // assuming you have a categories table

            if (!$success) {
                displayNotification("An error occurred while updating the category. Please try again later.", "error");
                redirect($redirect_url);
            }

            displayNotification("Category addition successful", "success");
            redirect($redirect_url);
            break;

        default:
            displayNotification("Invalid action", "error");
            redirect($redirect_url);
    }
}
