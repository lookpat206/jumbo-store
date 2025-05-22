<?php
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('_fn_db.php');
include('_fn.php');

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>จัดการข้อมูล</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="index_db.php">Dashboard</a></li>

          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) จำนวนลูกค้า -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>รอข้อมูล</h3>

              <p>ข้อมูลลูกค้า</p>
            </div>
            <!-- <div class="icon">
                <i class="ion-android-person"></i>
              </div> -->
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
        <div class="col-lg-3 col-6">
          <!-- small box จำนวนสินค้า-->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>รอข้อมูล<!--<sup style="font-size: 20px">%</sup> --></h3>

              <p>ข้อมูลสินค้า</p>
            </div>
            <!-- <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div> -->
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
        <div class="col-lg-3 col-6">
          <!-- small box จำนวนผู้ใช้ -->
          <div class="small-box bg-teal">
            <div class="inner">
              <h3>รอข้อมูล</h3>

              <p>ผู้ใช้งานระบบ</p>
            </div>
            <!-- <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>  -->
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

      </div>
      <!-- /.row -->

    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

</div>

<?php
include('_footer.php');
?>