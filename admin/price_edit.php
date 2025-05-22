<?php


include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');


// GET pri_id by price.php
$pri_id = $_GET['pri_id'];

//ดึงข้อมูล สินค้า
$result1 = fetch_prod();

//ดึงข้อมูล หน่วยนับ 
$result2 = fetch_unit();

//ดึงข้อมูล ราคาสินค้า จาก pri_id
$result3 = fetch_pri_detail_dy_priid($pri_id);
$row = mysqli_fetch_assoc($result3);
$pri_id = $row['pri_id'];
$pd_id = $row['pd_id'];
$pu_id = $row['pu_id'];
$pri_sell = $row['pri_sell'];
$pd_n = $row['pd_n'];
$pu_name = $row['pu_name'];
$c_id = $row['c_id'];



?>


<body class="">
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
                                <h3 class="card-title">แก้ไขราคาสินค้า</h3>
                            </div>
                            <form action="price_edit_save.php" method="post">
                                <input type="hidden" name="pri_id" value="<?= $pri_id ?>">
                                <input type="hidden" name="c_id" value="<?= $c_id ?>">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- ชื่อสินค้า -->
                                            <div class="form-group">
                                                <label>ชื่อสินค้า : </label>
                                                <select class=" form-control select2bs4" name="pd_id">
                                                    <option selected="selected" value="<?= $pd_id ?>"> <?= $pd_n ?></option>
                                                    <?php foreach ($result1 as $unit) { ?>
                                                        <option value="<?= $unit['pd_id'] ?>"><?= $unit['pd_n'] ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <!-- เลือกหน่วยนับ -->
                                                <div class="mb-3">
                                                    <select class=" form-control select2" name="pu_id">
                                                        <option selected="selected" value="<?= $pu_id ?>"><?= $pu_name ?></option>
                                                        <?php foreach ($result2 as $unit) { ?>
                                                            <option value="<?= $unit['pu_id'] ?>"><?= $unit['pu_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <!-- ราคาขาย -->
                                                <div class="mb-3">
                                                    <input type=" number" class="form-control" name="pri_sell" step="0.01" min="0" placeholder="<?= $pri_sell ?>">
                                                    <small class="form-text text-danger">ใส่ทศนิยม 2 ตำแหน่ง</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--  /.row -->
                                </div> <!-- /.card-body -->
                                <!-- บันทึก -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-danger">บันทึก</button>
                                    <a href="price.php?c_id=<?= $row['c_id'] ?>" class="btn btn-secondary">กลับ</a>

                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->


    </div>
    <!-- /.container-fluid -->

    </section>
    </div> <!-- /.content -->

    <?php
    include('_footer.php');

    ?>