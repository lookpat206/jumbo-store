<?php
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('_fn.php');

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="../admin/index.php">Home</a></li>
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
        <!-- กล่องที่ 1: จำนวนออเดอร์ -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>รอข้อมูล</h3>
              <p>จำนวนออเดอร์</p>
            </div>

          </div>
        </div>
        <!-- ./col -->

        <!-- กล่องที่ 2: วันที่ปัจจุบัน -->
        <div class="col-lg-6 col-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h4>วันที่</h4>
              <h1><?php echo date('Y-m-d'); ?></h>
            </div>
          </div>

        </div>
        <!-- ./col -->

        <!-- กล่องที่ 3: Icon รถเข็น และลิงก์ไปที่ orders.php -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h><i class="fas fa-shopping-cart"></i></hภ>
                <p>ออเดอร์</p>
            </div>
            <a href="orders.php" class="small-box-footer">สั่งสินค้า <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

    </div><!-- /.container-fluid -->

    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h1 class="card-title">ข้อมูลใบสั่งสินค้า</hๅ>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr class="table-info">
                    <th width="10%">ลำดับ</th>
                    <th width="30%">เลขที่ใบสั่งซื้อ</th>
                    <th width="20%">วันที่สั่ง</th>
                    <th width="20%">วันที่ส่ง</th>
                    <th width="10%">สถานะ</th>
                    <th width="10">รายละเอียด</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = " ";
                  if (mysqli_num_rows() > 0) {
                    $i = 0;
                    foreach ($result as $row) {
                      $i++;
                  ?>
                      <tr>
                        <td><?= $i ?></td>
                        <td> </td>
                        <td></td>
                        <td> </td>
                        <td> </td>
                        <td>
                          <a type="button" class="btn btn-block btn-primary" href="department.php?c_id=<?= $row['c_id'] ?>">เพิ่ม</a>
                        </td>


                      </tr>
                  <?php
                    }
                  } else {
                    echo '<tr><td colspan="6">ไม่พบข้อมูล</td></tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>


            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

</div>


<?php
include('_footer.php');
?>