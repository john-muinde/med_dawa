<?php
require_once 'api_auth.php';
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <?php
  if (isset($_SESSION['notification'])) {
    $message = $_SESSION['notification']['message'];
    $type = $_SESSION['notification']['type'];

    echo '<script>window.onload = () => toastr.' . $type . '("' . $message . '"); </script>';

    unset($_SESSION['notification']);
  }

  $user = $_SESSION['user'];

  $currentUrl = basename($_SERVER['PHP_SELF']); // Get current URL
  ?>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="./assets/images/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <span class="d-block">
          <?= $user["full_name"] ?>
        </span>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item <?= ($currentUrl === 'dashboard.php') ? 'active' : '' ?>">
          <a href="dashboard.php" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Admin Dashboard</p>
          </a>
        </li>
        <li class="nav-item <?= ($currentUrl === 'profile.php') ? 'active' : '' ?>">
          <a href="profile.php" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Admin Profile</p>
          </a>
        </li>
        <?php
        $navigationData = array(
          array(
            'title' => 'Users',
            'icon' => 'fas fa-user',
            'items' => array(
              array('url' => 'view_users.php', 'title' => 'View Users', 'icon' => 'far fa-file-alt'),
              array('url' => 'add_user.php', 'title' => 'Add Users', 'icon' => 'far fa-file-alt'),
            )
          ),
          array(
            'title' => 'Product Details',
            'icon' => 'fas fa-circle',
            'items' => array(
              array('url' => 'view_categories.php', 'title' => 'Categories', 'icon' => 'fas fa-layer-group', 'page' => 'category'),
              array('url' => 'view_products.php', 'title' => 'Products', 'icon' => 'fas fa-bag-shopping', 'page' => 'product'),
            )
          ),
          array(
            'title' => 'Order Details',
            'icon' => 'fas fa-circle',
            'items' => array(
              array('url' => 'view_orders', 'title' => 'All Orders', 'icon' => 'fas fa-shopping-cart', 'page' => 'orders'),

            )
          )
        );
        function checkActive($items)
        {
          global $currentUrl;
          foreach ($items as $item) {
            if ($currentUrl === $item['url']) {
              return ' menu-open';
            }
          }
          return ' menu-closed';
        }
        ?>

        <?php foreach ($navigationData as $navItem) : ?>
          <li class="nav-item<?= checkActive(isset($navItem['items']) ? $navItem['items'] : array()) ?>">
            <a href="#" class="nav-link">
              <i class="nav-icon <?= $navItem['icon'] ?>"></i>
              <p>
                <?= $navItem['title'] ?><i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <?php if (isset($navItem['items'])) : ?>
              <ul class="nav nav-treeview">
                <?php foreach ($navItem['items'] as $subItem) : ?>
                  <li class="nav-item<?= ($currentUrl === $subItem['url']) ? ' active' : '' ?>">
                    <a href="<?= $subItem['url'] ?>" class="nav-link">
                      <i class="<?= $subItem['icon'] ?> nav-icon"></i>
                      <p>
                        <?= $subItem['title'] ?>
                      </p>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>

        <!-- <li class="nav-item <?= ($currentUrl === 'reset_password.php') ? 'active' : '' ?>">
          <a href="reset_password.php" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>Reset Password</p>
          </a>
        </li> -->

        <li class="nav-item">
          <a href="includes/logout_inc.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>