<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');
include('../user/_fn.php');



//รับค่า id จาก plan.php
$pd_id = $_GET['pd_id'];
$od_id = $_GET['od_id'];

//exit($pl_id);
$result = fetch_pl_by_pdid_and_odid($pd_id, $od_id);
$row = mysqli_fetch_assoc($result);
$pd_n = $row['pd_n'];



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

                        <div class="card-body">
                            <input type="hidden" name="pd_id" value="<?= $pd_id ?>">
                            <p style="color: red; font-size: smaller;">โปรดตรวจสอบ: จำนวนสินค้าที่ได้รับไม่ตรงกับจำนวนที่สั่ง</p>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>ลูกค้า</label>
                                        <input name="c_cbb" type="text" class="form-control" value="<?= htmlspecialchars($row['c_abb']) ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>หน่วยนับ</label>
                                        <input name="pu_name" type="text" class="form-control" value="<?= htmlspecialchars($row['pu_name']) ?>" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>จำนวนซื้อ</label>
                                        <input name="shop_qty" type="number" step="0.01" class="form-control" value="<?= $row['shop_qty'] ?>" readonly>
                                    </div>
                                    <form action="inv_edit_save.php" method="post">
                                        <div class="form-group">

                                            <label>จำนวนสั่ง</label>
                                            <input name="qty" type="number" step="0.01" class="form-control" value="<?= $row['qty'] ?>">
                                        </div>
                                </div>
                            </div>

                        </div> <!-- /.card-body -->
                        <!-- บันทึก -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-danger">บันทึก</button>
                            <a href="inv.php" class="btn btn-secondary">กลับ</a>
                        </div>
                        </form>
                    </div>
                    <!-- /.card -->
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
<!-- /.content-wrapper -->




<?php
include('_footer.php');
?>