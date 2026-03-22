<?php
session_start();

include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');
include('../admin/_fn.php');



// ตรวจสอบว่ามีการ login แล้วหรือไม่ และ u_id ถูกเก็บไว้ใน session หรือไม่
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit;
}
$u_id = isset($_SESSION['u_id']) ? intval($_SESSION['u_id']) : 0;
//print_r($u_id); // แสดงค่า u_id สำหรับดีบัก

//ดึงข้อมูล สถานที่ซื้อสินค้า , ร้านค้า , สินค้า , ผู้รับผิดชอบ เพื่อใช้ในการเลือกข้อมูล
$result1 = fetch_prod();
$result2 = fetch_cust();


//รับค่า id จาก plan.php
$pd_id = $_GET['pd_id'];
$shop_id = $_GET['shop_id'];

//exit($pl_id);
$result = fetch_sp_list_by_pdspid($pd_id, $shop_id);
$row = mysqli_fetch_assoc($result);
$pd_n = $row['pd_n'];
$pd_id = $row['pd_id'];
$pu_id = $row['pu_id'];
$shop_id = $row['shop_id'];
$shop_qty = $row['shop_qty'];




?>

<div class="content">
    <!-- Content Header (Page header)  -->
    <section class="content-header">
        <!--<div class="container-fluid">
        <div class="row mb-2">
          <div class="col-6 mx-auto">
            <h1>ข้อมูลลูกค้า</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div> /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 mx-auto">

                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">ชื่อสินค้า : <?= $pd_n ?></h3>
                        </div>

                        <form action="phc_re_save.php" method="post">

                            <div class="card-body">

                                <input type="hidden" name="pd_id" value="<?= $pd_id ?>">
                                <input type="hidden" name="shop_id" value="<?= $shop_id ?>">
                                <input type="hidden" name="pu_id" value="<?= $pu_id ?>">

                                <div class="form-group">
                                    <label>จำนวน</label>
                                    <input type="number"
                                        class="form-control text-end"
                                        name="qty"
                                        value="<?= number_format($shop_qty, 2, '.', '') ?>"
                                        step="0.01"
                                        min="0">

                                </div>

                                <div class="form-group">
                                    <label for="">สาเหตุการคืนสินค้า</label>
                                    <textarea name="note" class="form-control" id="" placeholder="สาเหตุ"></textarea>
                                </div>


                            </div>

                            <div class="card-footer">

                                <button type="submit" class="btn btn-danger ">
                                    คืนสินค้า
                                </button>


                                <a href="ph_c.php" class="btn btn-secondary float-right">
                                    กลับ
                                </a>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->




<?php
include('_footer.php');
?>