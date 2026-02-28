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
        <a href="index.php" class="d-block">Admin</a>
      </div>
    </div>



    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


        <!-- จัดการข้อมูล -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              จัดการข้อมูล
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="prod.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ข้อมูลสินค้า</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cust.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ข้อมูลลูกค้า</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="market.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ข้อมูลสถานที่ซื้อสินค้า</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="supp.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ข้อมูลร้านค้า</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="user.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ข้อมูลพนักงาน</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- สั่งซื้อสินค้า -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>
              สั่งซื้อสินค้า
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="order.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>สร้างใบสั่งซื้อ</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="po.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>ข้อมูลใบสั่งซื้อ</p>
              </a>
            </li>

          </ul>
        </li>
        <!-- แผนการซื้อสินค้า -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>
              แผนการซื้อสินค้า
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="plan.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>สร้างแผนการซื้อสินค้า</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="shopping.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>รายการซื้อสินค้า</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="inv.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>รายการสินค้าเตรียมจัดส่ง</p>
              </a>
            </li>
          </ul>
        </li>




      </ul>

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>