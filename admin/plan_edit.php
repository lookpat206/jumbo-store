<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

//ดึงข้อมูล สถานที่ซื้อสินค้า , ร้านค้า , สินค้า , ผู้รับผิดชอบ เพื่อใช้ในการเลือกข้อมูล
$result1 = fetch_mark();
$result2 = fetch_supp();
$result3 = fetch_prod();
$result4 = fetch_user();

//รับค่า id จาก plan.php
$plan = $_GET['plan_id'];

//exit($plan);

//ดึงข้อมูลแผนซื้อสินค้า จาก plan_id

$result5 = fetch_plan_by_planid($plan);

$row = mysqli_fetch_assoc($result5);
$m_name = $row['mk_name'];
$s_name = $row['sp_name'];
$p_name = $row['pd_n'];
$u_n = $row['u_name'];
$mk_id = $row['mk_id'];
$sp_id = $row['sp_id'];
$pd_id = $row['pd_id'];
$u_id = $row['u_id'];
$plan_id = $row['plan_id'];

//exit("สถานที่ซื้อสินค้า: $m_name, ร้านค้า: $s_name, สินค้า: $p_name, ผู้รับผิดชอบ: $u_n");



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
                        <form action="plan_edit_save.php" method="post">
                            <div class="card-body">
                                <input type="hidden" name="plan_id" value="<?= $plan_id ?>">

                                <!-- สถานที่ซื้อสินค้า -->
                                <div class="form-group">
                                    <label for="type">สถานที่ซื้อสินค้า:</label>
                                    <select class="form-control select2" name="mk_id" style="width: 100%;">
                                        <option selected="selected" value="<?= $mk_id ?>"><?= $m_name ?></option>
                                        <?php foreach ($result1 as $row) { ?>
                                            <option value="<?= $row['mk_id'] ?>"> <?= $row['mk_name'] ?> </option>
                                        <?php } ?>

                                    </select>

                                </div>

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

                                <!-- สินค้า -->

                                <div class="form-group">
                                    <label for="type">ชื่อสินค้า:</label>
                                    <select class="form-control select2" name="pd_id" style="width: 100%;">
                                        <option selected="selected" value="<?= $pd_id ?>"><?= $p_name ?></option>
                                        <?php foreach ($result3 as $row) { ?>
                                            <option value="<?= $row['pd_id'] ?>"> <?= $row['pd_n'] ?> </option>
                                        <?php } ?>

                                    </select>

                                </div>

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