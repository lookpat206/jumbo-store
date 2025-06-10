<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');
include('../user/_fn.php');

//ดึงข้อมูล สถานที่ซื้อสินค้า , ร้านค้า , สินค้า , ผู้รับผิดชอบ เพื่อใช้ในการเลือกข้อมูล
$result1 = fetch_mark();
$result2 = fetch_supp();
$result3 = fetch_prod();
$result4 = fetch_user();

//รับค่า id จาก plan.php
$pl_id = $_GET['pl_id'];

//exit($pl_id);
$result = fetch_sp_list_by_plid($pl_id);
$row = mysqli_fetch_assoc($result);
$mk_id = $row['mk_id'];
$sp_id = $row['sp_id'];
$u_id = $row['u_id'];
$mk_name = $row['mk_name'];
$sp_name = $row['sp_name'];
$pd_n = $row['pd_n'];
$u_name = $row['u_name'];
$pu_name = $row['pu_name'];
$sp_price = $row['sp_price'];
$sp_status = $row['sp_status'];
$quantity = $row['quantity'];
$pl_id = $row['pl_id'];

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
                            <h3 class="card-title">แก้ไขรายการซื้อสินค้า</h3>
                        </div>
                        <form action="sp_edit_save.php" method="post">
                            <div class="card-body">
                                <input type="hidden" name="pl_id" value="<?= $pl_id ?>">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <!-- สถานที่ซื้อสินค้า -->
                                            <label for="type">สถานที่ซื้อสินค้า:</label>
                                            <select class="form-control select2" name="mk_id" style="width: 100%;">
                                                <option selected="selected" value="<?= $mk_id ?>"><?= $mk_name ?></option>
                                                <?php foreach ($result1 as $row) { ?>
                                                    <option value="<?= $row['mk_id'] ?>"> <?= $row['mk_name'] ?> </option>
                                                <?php } ?>

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- ร้านค้า -->
                                        <div class="form-group">
                                            <label for="type">ร้านค้า:</label>
                                            <select class="form-control select2" name="sp_id" style="width: 100%;">
                                                <option selected="selected" value="<?= $sp_id ?>"><?= $sp_name ?></option>
                                                <?php foreach ($result2 as $row) { ?>
                                                    <option value="<?= $row['sp_id'] ?>"> <?= $row['sp_name'] ?> </option>
                                                <?php } ?>

                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-6">
                                        <!-- ผู้รับผิดชอบ -->
                                        <div class="form-group">
                                            <label for="type">ผู้รับผิดชอบ :</label>
                                            <select class="form-control select2" name="u_id" style="width: 100%;">
                                                <option selected="selected" value="<?= $u_id ?>"><?= $u_name ?></option>
                                                <?php foreach ($result4 as $row) { ?>
                                                    <option value="<?= $row['u_id'] ?>"> <?= $row['u_name'] ?> </option>
                                                <?php } ?>

                                            </select>

                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>สินค้า</label>
                                            <input type="text" class="form-control" placeholder="<?= $pd_n ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- จำนวนสินค้า-->
                                        <div class="form-group">
                                            <label>จำนวนสินค้า</label>
                                            <input type=" number" class="form-control" name="quantity" step="0.01" min="0" placeholder="<?= $quantity ?>">
                                            <small class="form-text text-danger">ใส่ทศนิยม 2 ตำแหน่ง</small>

                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>หน่วยนับ</label>
                                            <input type="text" class="form-control" placeholder="<?= $pu_name ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>ราคาซื้อสินค้า</label>
                                            <input type=" number" class="form-control" name="sp_price" step="0.01" min="0" placeholder="<?= $sp_price ?>">
                                            <small class="form-text text-danger">ใส่ทศนิยม 2 ตำแหน่ง</small>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>สถานะ</label>
                                            <select multiple class="form-control" name="sp_status" style="width: 100%;">
                                                <option value="<?= $sp_status ?>">แก้ไขรายการสำเร็จ</option>
                                                <option value="1">ซื้อสำเร็จ</option>
                                                <option value="2">ไม่มีสินค้า</option>
                                                <option value="3">รอสินค้าวันต่อไป</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- /.card-body -->

                            <!-- บันทึก -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger">บันทึก</button>
                                <a href="shopping.php" class="btn btn-secondary">กลับ</a>
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