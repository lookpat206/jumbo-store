<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
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
          <a href="" class="d-block">Admin</a>
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
                <a href="cust.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ข้อมูลลูกค้า</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="prod.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ข้อมูลสินค้า</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="user.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ข้อมูลผู้ใช้</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="supplier.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ข้อมูลร้านค้า</p>
                </a>
              </li>
            </ul>
          </li>
            <!-- สั่งสินค้า -->
          <li class="nav-item">
             
            <a href="od.php" class="nav-link">
              <i class="nav-icon fas fa-cart-plus"></i>
              <p>
                การสั่งสินค้า
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
             <!-- ข้อมูลซื้อสินค้า -->
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                จัดการซื้อสินค้า
              </p>
            </a>
          </li>
          <li class="nav-item">
             <!-- เพิ่มหน้าเพจการซื้อสินค้า -->
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-carrot"></i>
              <p>
                จัดการสินค้าคงเหลือ
              </p>
            </a>
          </li>
          </ul>
          
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>