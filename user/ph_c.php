<?php
//แสดงข้อมูลรายการซื้อสินค้าเสร็จแล้ว

session_start();

include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('_fn.php');
include('../admin/_fn_db.php');

// ตรวจสอบว่ามีการ login แล้วหรือไม่ และ u_id ถูกเก็บไว้ใน session หรือไม่
if (!isset($_SESSION['u_id'])) {
  header("Location: login.php");
  exit;
}
$u_id = isset($_SESSION['u_id']) ? intval($_SESSION['u_id']) : 0;
//print_r($u_id); // แสดงค่า u_id สำหรับดีบัก




$created = null;
$result = null;
$summary = null;

if (isset($_POST['created'])) {
  $created = date("Y-m-d", strtotime($_POST['created']));
  $u_id = $_SESSION['u_id'];

  $result = syn_stock_list($created, $u_id);
  $summary = summary_syn_stock($created, $u_id);
}

$created_show = "";
$emp_name = "";

if (isset($_POST['created'])) {
  $created = date("Y-m-d", strtotime($_POST['created']));
  $created_show = date("d/m/Y", strtotime($created));

  $u_id = $_SESSION['u_id'];
  $emp_name = $_SESSION['u_user']; // ชื่อพนักงาน
}



if (isset($_SESSION['msg'])) {
  echo '<div class="alert alert-info">' . $_SESSION['msg'] . '</div>';
  unset($_SESSION['msg']);
}
?>



<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>สรุปรายการสินค้าเข้า</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
        <!-- กล่องที่ 1: ค้นหาบิล -->
        <div class="col-6 mx-auto">
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">ซื้อสำเร็จ</h3>
            </div>

            <!-- form -->
            <form action="" method="post">

              <div class="card-body">
                <!-- Date -->
                <div class="form-group">
                  <label>ค้นหารายการซื้อสำเร็จประจำวันที่ :</label>

                  <div class="input-group date" id="reservationdate" data-target-input="nearest">
                    <input type="text"
                      name="created"
                      class="form-control datetimepicker-input"
                      data-target="#reservationdate"
                      required />

                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                      <div class="input-group-text">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                  </div>

                </div>

              </div>
              <!-- footer -->
              <div class="card-footer">
                <button type="submit" id="btn_summary" class="btn btn-danger">
                  ค้นหา
                </button>
              </div>
            </form>
          </div>
        </div>
        <!-- กล่องที่ 2:แสดงจำนวน  -->
        <div class="col-3 mx-auto ">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="	fas fa-portrait"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">ยอดซื้อตามจริง</span>
              <span class="info-box-number">
                <?= isset($summary['total_price']) ? number_format($summary['total_price'], 2) . " บาท" : "-" ?>
              </span>

              </span>
            </div>
            <!-- /.info-box-content -->
          </div>

          <!-- /.info-box -->

        </div>
        <!-- ./col -->
        <!-- กล่องที่ 3:  -->
        <div class="col-3 mx-auto ">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="	fas fa-portrait"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">จำนวนตลาด</span>
              <span class="info-box-number">
                <?= $summary['total_market'] ?? "-" ?>
              </span>

              </span>
            </div>
            <!-- /.info-box-content -->
          </div>

          <!-- /.info-box -->
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="	fas fa-portrait"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">จำนวนร้านค้า</span>
              <span class="info-box-number">
                <?= $summary['total_shop'] ?? "-" ?>
              </span>


              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="	fas fa-portrait"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">จำนวนรายการ</span>
              <span class="info-box-number"></span><?= $summary['total_item'] ?? "-" ?></span>


              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->


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
              <h1 class="card-title">รายการสินค้าเข้า โดย <?= $emp_name ?: '-' ?> ประจำวันที่ <?= $created_show ?: '-' ?></h1>


            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr class="table-info">
                    <th width="10%">ลำดับ</th>
                    <th width="20%">ชื่อร้าน</th>
                    <th width="20%">ชื่อสินค้า</th>
                    <th width="10%">จำนวน</th>
                    <th width="10%">หน่วยนับ</th>
                    <th width="10%">ราคาต่อหน่วย</th>

                    <th width="20%">ผลรวม</th>
                    <th width="10">คืนสินค้า</th>

                  </tr>
                </thead>
                <tbody>

                  <?php
                  $total_price = 0;

                  if ($result && mysqli_num_rows($result) > 0) {

                    $i = 1;

                    while ($row = mysqli_fetch_assoc($result)) {

                      $total_price += $row['total'];
                  ?>

                      <tr>

                        <td><?= $i++ ?></td>

                        <td><?= $row['sp_name'] ?></td>

                        <td><?= $row['pd_n'] ?></td>

                        <td><?= $row['shop_qty'] ?></td>

                        <td><?= $row['pu_name'] ?></td>

                        <td><?= number_format($row['shop_price'], 2) ?></td>

                        <td><?= number_format($row['total'], 2) ?></td>

                        <td>
                          <a class="btn btn-danger"
                            href="phc_return.php?pd_id=<?= $row['pd_id'] ?>&shop_id=<?= $row['shop_id'] ?>">
                            คืนสินค้า
                          </a>
                        </td>

                      </tr>

                  <?php }
                  } else {

                    echo '<tr><td colspan="8" class="text-center">ไม่พบข้อมูล</td></tr>';
                  }
                  ?>
                  <tr class="table-warning">

                    <td colspan="6"><b>ยอดรวมทั้งหมด</b></td>

                    <td><b><?= number_format($total_price, 2) ?></b></td>

                    <td></td>

                  </tr>

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