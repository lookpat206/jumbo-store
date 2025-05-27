<?php
//แสดงข้อมูลใบสั่งซื้อ

session_start();

include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('_fn.php');

$total_od = fetch_totalod();



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
              <h3><?= $total_od ?></h3>
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
                    <th width="10%">เลขที่ใบสั่งซื้อ</th>
                    <th width="20%">ชื่อลูกค้า</th>
                    <th width="10%">วันที่สั่ง</th>
                    <th width="10%">วันที่ส่ง</th>
                    <th width="20%">สถานะ</th>
                    <th width="10">รายละเอียด</th>
                    <th width="10%">ยกเลิก</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = get_orders();
                  $i = 0;
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $i++;
                      $c_id = $row['c_id'];
                      $od_id = $row['od_id'];
                  ?>
                      <tr>
                        <td><?= $i ?></td>
                        <td><?= $row['od_id'] ?></td>
                        <td><?= $row['c_name'] ?></td>
                        <td><?= $row['od_day'] ?></td>
                        <td><?= $row['dv_day'] ?></td>
                        <td><?= $row['status_id'] ?></td>
                        <td>
                          <a type="button" class="btn btn-block btn-primary" href="po_get_detail.php?od_id=<?= $row['od_id'] ?>">รายละเอียด</a>
                        </td>
                        <td>
                          <a onclick="return confirm('คุณต้องการลบใบสั่งซื้อหรือไม่?')" type="button" class="btn btn-block btn-danger" href="po_delete_u.php?od_id=<?= $row['od_id'] ?>">ยกเลิกใบสั่ง</a>
                        </td>
                      </tr>
                  <?php
                    }
                  } else {
                    echo '<tr><td colspan="7" class="text-center">ไม่พบข้อมูล</td></tr>';
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