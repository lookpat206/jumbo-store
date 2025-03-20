<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

$result1 = fetch_mark();
$result2 = fetch_supp();
$result3 = fetch_prod();
$result4 = fetch_user();

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
                            <h3 class="card-title">เพิ่มข้อมูลแผนซื้อสินค้า</h3>
                        </div>
                        <form action="plan_add_save.php" method="post">
                            <div class="card-body">

                                <!-- สถานที่ซื้อสินค้า -->
                                <div class="form-group">
                                    <label for="type">สถานที่ซื้อสินค้า:</label>
                                    <select class="form-control select2" name="mk_id" style="width: 100%;">
                                        <option selected="selected" value="">-- เลือกข้อมูล --</option>
                                        <?php foreach ($result1 as $row) { ?>
                                            <option value="<?= $row['mk_id'] ?>"> <?= $row['mk_name'] ?> </option>
                                        <?php } ?>

                                    </select>

                                </div>

                                <!-- ร้านค้า -->
                                <div class="form-group">
                                    <label for="type">ร้านค้า:</label>
                                    <select class="form-control select2" name="sp_id" style="width: 100%;">
                                        <option selected="selected" value="">-- เลือกข้อมูล --</option>
                                        <?php foreach ($result2 as $row) { ?>
                                            <option value="<?= $row['sp_id'] ?>"> <?= $row['sp_name'] ?> </option>
                                        <?php } ?>

                                    </select>

                                </div>

                                <!-- สินค้า -->

                                <div class="form-group">
                                    <label for="type">ชื่อสินค้า:</label>
                                    <select class="form-control select2" name="pd_id" style="width: 100%;">
                                        <option selected="selected" value="">-- เลือกข้อมูล --</option>
                                        <?php foreach ($result3 as $row) { ?>
                                            <option value="<?= $row['pd_id'] ?>"> <?= $row['pd_n'] ?> </option>
                                        <?php } ?>

                                    </select>

                                </div>

                                <!-- ผู้รับผิดชอบ -->
                                <div class="form-group">
                                    <label for="type">ผู้รับผิดชอบ :</label>
                                    <select class="form-control select2" name="u_id" style="width: 100%;">
                                        <option selected="selected" value="">-- เลือกข้อมูล --</option>
                                        <?php foreach ($result4 as $row) { ?>
                                            <option value="<?= $row['u_id'] ?>"> <?= $row['u_name'] ?> </option>
                                        <?php } ?>

                                    </select>

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