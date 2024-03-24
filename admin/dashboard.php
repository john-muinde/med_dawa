<?php
$page = "Dashboard";

include 'header.php';

function getCount($table, $conditions = null)
{
    $sql = "SELECT COUNT(*) as count FROM " . $table;
    if ($conditions) {
        $firstCondition = true;
        foreach ($conditions as $condition => $value) {
            if (strpos($condition, 'date') !== false) {
                $conditionSql = " " . $condition . " = DATE(" . $value . ")";
            } else {
                $conditionSql = " " . $condition . " = '" . $value . "'";
            }
            if ($firstCondition) {
                $sql .= " WHERE" . $conditionSql;
                $firstCondition = false;
            } else {
                $sql .= " AND" . $conditionSql;
            }
        }
    }
    return select_rows($sql)[0]['count'];
}


// Get counts
$today_product_count = getCount('product', ['product_date_created' => date('Y-m-d')]);
$today_order_count = getCount('orders', ['date_created' => date('Y-m-d')]);
$paid_orders = getCount('orders', ['payment_status' => 'paid', 'date_created' => date('Y-m-d')]);
$pending_order_count = getCount('orders', ['payment_status' => 'pending', 'date_created' => date('Y-m-d')]);

$total_orders = getCount('orders');
$product_count = getCount('product');
$out_of_stock_count = getCount('product', ['product_in_stock' => 'no']);
$low_stock_count = count(select_rows("SELECT * FROM product WHERE product_quantity <= 10") ?? []);

$user_count = getCount('users', ['role' => 'user', 'status' => 'active']);
$inactive_user_count = getCount('users', ['role' => 'user', 'status' => 'inactive']);
$admin_count = getCount('users', ['role' => 'admin']);
$inactive_admin_count = getCount('users', ['role' => 'admin', 'status' => 'inactive']);

function generateBox($color, $count, $description, $icon, $link, $condition = [])
{
    if (!empty($condition)) {
        $link .= '?' . http_build_query($condition);
    }
    ob_start();
?>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-<?= $color ?>">
            <div class="inner">
                <h3><?= $count ?></h3>
                <p><?= $description ?></p>
            </div>
            <div class="icon">
                <i class="fas <?= $icon ?>" style="font-size: 60px;"></i>
            </div>
            <a href="<?= $link ?>" class="small-box-footer">View details <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
<?php
    return ob_get_clean();
}

$user = $_SESSION["user"];
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid mt-2">
            <!-- ------------------------------------------------------------------------------------------------------- -->
            <div class="row">
                <?php
                echo generateBox('link', $product_count, "Total Products", 'fa fa-calendar-times', 'view_products.php');
                echo generateBox('info', $total_orders, "Total Orders", 'fa fa-list', '#');
                echo generateBox('dark', $out_of_stock_count, "Out of Stock", 'fa fa-archive', 'view_products.php', array('product_in_stock' => 'no'));
                echo generateBox('light', $low_stock_count, "Low Stock", 'fa fa-exclamation-triangle', 'view_products.php', array('product_quantity' => '<= 10'));
                ?>
            </div>
            <!-- ------------------------------------------------------------------------------------------------------- -->
            <hr>
            <h3 class="p3">User Data</h3>

            <div class="row">
                <?php
                echo generateBox('primary', $user_count, "Active Users", 'fa fa-user', 'view_users.php', array('role' => 'user'));
                echo generateBox('warning', $inactive_user_count, "Inactive Users", 'fa fa-user-times', 'view_users.php', array('role' => 'user', 'status' => 'inactive'));
                echo generateBox('primary', $admin_count, "Active Admins", 'fa fa-user-shield', 'view_users.php', array('role' => 'admin'));
                echo generateBox('warning', $inactive_admin_count, "Inactive Admins", 'fa fa-user-shield-slash', 'view_users.php', array('status' => 'inactive', 'role' => 'admin'));
                ?>
            </div>
        </div>
    </section>
</div>
<?php include "includes/footer.php"; ?>