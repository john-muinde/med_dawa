<?php
include 'connect.php';
include 'operations_model.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$images = select_rows("SELECT * FROM PRODUCT");

$cart = [];

function displayProduct($product, $cart, $redirect = 'index.php')
{
    $isInCart = in_array($product['id'], array_column($cart, 'product_id')) ? 'fa-heart' : 'fa-heart-o';
    $formattedPrice = number_format($product["product_price"], 2);

    ob_start();
?>
    <div class="image-container col-lg-3 col-md-1">
        <div class="image-wrapper gallery-item">
            <a href="<?= file_url . $product['product_image'] ?>" class="galelry-lightbox">
                <img src="<?= file_url . $product["product_image"] ?>" alt="<?= $product["product_name"] ?>" class="img-fluid" />
            </a>

        </div>
        <div class="icon-wrapper">
            <div class="image-info ">
                <span class="image-name" style="margin-bottom: 10px;"><?= $product["product_name"] ?></span>
                <span class="image-price" style="font-weight: bold;">Kshs. <?= $formattedPrice ?></span>
            </div>
            <div class="image-icons">
                <i class="fa fa-shopping-cart cart-icon" style="font-size: 25px;  cursor: pointer"></i>
                <!-- <i class="fa {$isInCart} cart-icon" style="font-size: 25px; cursor: pointer" onclick="addToCart({$product['id']},'{$redirect}')"></i> -->
            </div>
        </div>
    </div>
<?php
    $html = ob_get_clean();
    echo $html;
}
