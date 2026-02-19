<?php

$c_id = $_GET['c_id'];

?>

<?php

include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

//ดึงข้อมูล สินค้า
$result1 = fetch_prod();

//ดึงข้อมูล หน่วยนับ 
$result2 = fetch_unit();

//ดึงข้อมูลลูกค้า
$result3 = fetch_cust_by_cid($c_id);
$row = mysqli_fetch_assoc($result3);
$c_name = $row['c_name'];

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
                                <h3 class="card-title">เพิ่มข้อมูลราคาสินค้า</h3>
                            </div>
                            <form action="price_save.php" method="post">
                                <input type="hidden" name="c_id" value="<?= $c_id ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- ชื่อสินค้า -->
                                            <div class="form-group">
                                                <label>ชื่อสินค้า : </label>
                                                <select class=" form-control select2bs4" name="pd_id">
                                                    <option selected="selected" value=""> -- เลือกสินค้า -- </option>
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
                                                        <option selected="selected" value="1"> -- กิโลกรัม --</option>
                                                        <?php foreach ($result2 as $unit) { ?>
                                                            <option value="<?= $unit['pu_id'] ?>"><?= $unit['pu_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <!-- ราคาขาย -->
                                                <div class="mb-3">
                                                    <input type=" number" class="form-control" name="pri_sell" step="0.01" min="0" placeholder="ราคาสินค้า">
                                                    <small class="form-text text-danger">ใส่ทศนิยม 2 ตำแหน่ง</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--  /.row -->
                                </div> <!-- /.card-body -->
                                <!-- บันทึก -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-danger">บันทึก</button>

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

            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">ข้อมูลราคาสินค้า</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-info">
                                            <th width="10%">ลำดับ</th>
                                            <th width="40%">สินค้า</th>
                                            <th width="20%">หน่วยนับ</th>
                                            <th width="20%">ราคาขาย</th>
                                            <th width="10%">ลบข้อมูล</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result4 = fetch_pri_detail_dy_pdid($c_id);
                                        if (mysqli_num_rows($result4) > 0) {
                                            $i = 0;
                                            foreach ($result4 as $row) {
                                                $i++;
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $row['pd_n'] ?></td>
                                                    <td><?= $row['pu_name'] ?></td>
                                                    <td><?= $row['pri_sell'] ?></td>
                                                    <td>
                                                        <a onClick="return confirm('กรุณาตรวจสอบข้อมูล')" class="btn btn-danger btn-sm" href="price_delete.php?pri_id=<?= $row['pri_id'] ?>$c_id=<? $row['c_id'] ?>">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="5">ไม่พบข้อมูล</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div><!-- /.card-body -->
                            <div class="card-footer">

                                <a href="price.php?c_id=<?= $c_id; ?>" class="btn btn-secondary">กลับ</a>


                            </div>

                        </div><!-- /.card -->

                    </div> <!-- /.col -->

                </div><!-- /.row -->
            </div>
    </div>
    <!-- /.container-fluid -->

    </section>
    </div> <!-- /.content -->


    <?php
    include('_footer.php');
    ?>