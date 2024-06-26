<?php

//ตรวจสอบค่าพารามิเตอร์ที่ได้รับจาก URL
if (isset($_GET['c_id']) && isset($_GET['pd_id'])) {
    $c_id = intval($_GET['c_id']);
    $pd_id = intval($_GET['pd_id']);

    // ตรวจสอบค่าพารามิเตอร์ที่ได้รับ
    if ($c_id > 0 && $pd_id > 0) {
        // ดำเนินการตามค่าที่ได้รับ เช่น การเพิ่มข้อมูลในฐานข้อมูล
    } else {
        echo "ค่าพารามิเตอร์ไม่ถูกต้อง";
    }
} else {
    echo "ไม่ได้รับค่าพารามิเตอร์";
}

echo $c_id . $pd_id;



?>

<?php

include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

$result1 = fetch_prod();
$row = mysqli_fetch_assoc($result1);
$pd_n = $row['pd_n'];
//ดึงข้อมูล หน่วยนับ 
$result2 = fetch_unit();

//ดึงข้อมูลลูกค้า
$result4 = fetch_cust();
$row = mysqli_fetch_assoc($result4);
$c_name = $row['c_name'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการข้อมูลแผนก/ครัว</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

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
                                <input type="hidden" name="pd_id" value="<?= $pd_id ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- ชื่อสินค้า -->
                                            <div class="form-group">
                                                <input value="<?= $pd_n ?>" type="text" name="pd_n" class="form-control" disabled>


                                            </div>
                                            <div class="form-group">

                                                <input value="<?= $c_name ?>" type="text" name="c_name" class="form-control" disabled>

                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <select class=" form-control select2" name="pu_id">
                                                        <?php foreach ($result2 as $unit) { ?>
                                                            <option value="<?= $unit['pu_id'] ?>"><?= $unit['pu_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
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
                                            <th width="20">ราคาขาย</th>
                                            <th width="10%">ลบข้อมูล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result3 = fetch_pri_detail_dy_pdid($pd_id);
                                        if (mysqli_num_rows($result3) > 0) {
                                            $i = 0;
                                            foreach ($result3 as $row) {
                                                $i++;
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $row['pd_n'] ?></td>
                                                    <td><?= $row['pu_name'] ?></td>
                                                    <td><?= $row['pri_sell'] ?></td>
                                                    <td>
                                                        <a onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm" href="depart_delete.php?pri_id=<?= $row['pri_id'] ?>">
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
                                <a href="cust.php" class="btn btn-secondary">กลับ</a>
                            </div>

                        </div><!-- /.card -->

                    </div> <!-- /.col -->

                </div><!-- /.row -->
            </div>
    </div>
    <!-- /.container-fluid -->

    </section>
    </div> <!-- /.content -->







    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>