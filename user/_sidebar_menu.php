<?php


?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">JumBo-Store</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/avatar2.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a class="d-block">ลูกค้า</a>
      </div>
    </div>



    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <!-- สั่งสินค้า -->
          <a href="orders.php" class="nav-link">
            <i class="nav-icon fas fa-cart-plus"></i>
            <p>
              สั่งซื้อสินค้า
              <!-- <span class="right badge badge-danger">New</span> -->
            </p>
          </a>
        </li>
        <li class="nav-item">
          <!-- รายการซื้อสินค้า -->
          <a href="po.php" class="nav-link">
            <i class="nav-icon fas fa-dolly-flatbed"></i>
            <p>
              ใบสั่งสินค้า
            </p>
          </a>
        </li>
        <li class="nav-item">
          <!-- รายการซื้อสินค้า -->
          <a href="pl.php" class="nav-link">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              รายการซื้อสินค้า
            </p>
          </a>
        </li>

      </ul>

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>