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

//exit($plan);





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
                                                <option selected="selected" value="<?= $mk_id ?>"><?= $m_name ?></option>
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
                                                <option selected="selected" value="<?= $sp_id ?>"><?= $s_name ?></option>
                                                <?php foreach ($result2 as $row) { ?>
                                                    <option value="<?= $row['sp_id'] ?>"> <?= $row['sp_name'] ?> </option>
                                                <?php } ?>

                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="type">ชื่อสินค้า:</label>
                                            <select class="form-control select2" name="pd_id" style="width: 100%;">
                                                <option selected="selected" value="<?= $pd_id ?>"><?= $p_name ?></option>
                                                <?php foreach ($result3 as $row) { ?>
                                                    <option value="<?= $row['pd_id'] ?>"> <?= $row['pd_n'] ?> </option>
                                                <?php } ?>

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- ผู้รับผิดชอบ -->
                                        <div class="form-group">
                                            <label for="type">ผู้รับผิดชอบ :</label>
                                            <select class="form-control select2" name="u_id" style="width: 100%;">
                                                <option selected="selected" value="<?= $u_id ?>"><?= $u_n ?></option>
                                                <?php foreach ($result4 as $row) { ?>
                                                    <option value="<?= $row['u_id'] ?>"> <?= $row['u_name'] ?> </option>
                                                <?php } ?>

                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>สินค้า</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>หน่วยนับ</label>
                                            <input type="text" class="form-control" placeholder="Enter ..." disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>ราคาซื้อสินค้า</label>
                                            <input type="text" class="form-control" placeholder="Enter ...">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>สถานะ</label>
                                            <select multiple class="form-control">
                                                <option value="0"></option>
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
                                <a href="plan.php" class="btn btn-secondary">กลับ</a>
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