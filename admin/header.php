<?php
require 'api_auth.php';
require_once 'operations_model.php';
?>

<!DOCTYPE html>
<html lang="en" style="height: auto !important;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MEDDAWA |
        <?= ucwords($page) ?>
    </title>
    <?php include 'includes/meta.php'; ?>
    <?= $extraCss ?? '' ?>
</head>

<body class="sidebar-mini" style="height: auto;">
    <div class="wrapper">
        <?php include "includes/nav.php"; ?>
        <?php include "includes/main_sidebar.php"; ?>
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