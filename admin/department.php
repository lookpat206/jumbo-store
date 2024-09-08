<?php

include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

// GET c_id by cust.php
$c_id = $_GET['c_id'];



// เรียกใช้ function 
$result = fetch_cust_by_cid($c_id);
$row = mysqli_fetch_assoc($result);
$c_name = $row['c_name'];

//echo $c_id;

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
                        <h3><?= $c_name ?></h3>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">เพิ่มข้อมูลแผนก/ครัว</h3>
                            </div>
                            <form action="depart_add_save.php" method="post">
                                <input type="hidden" name="c_id" value="<?= $c_id ?>">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">

                                                <input name="dp_name" type="text" class="form-control" placeholder="แผนก/ครัว">
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
                                <h3 class="card-title">ข้อมูลแผนกและครัว</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-info">
                                            <th width="20%">ลำดับ</th>

                                            <th width="60%">แผนก/ครัว</th>
                                            <th width="20%">ลบข้อมูล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result1 = fetch_depart_by_id($c_id);
                                        if (mysqli_num_rows($result1) > 0) {
                                            $i = 0;
                                            foreach ($result1 as $row) {
                                                $i++;
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>

                                                    <td><?= $row['dp_name'] ?></td>
                                                    <td>
                                                        <a onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm" href="depart_delete.php?dp_id=<?= $row['dp_id'] ?>&c_id=<?= $row['c_id'] ?>">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="4">ไม่พบข้อมูล</td></tr>';
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
    </div> <!-- /.container-fluid -->
    </section>
    </div> <!-- /.content -->







    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>