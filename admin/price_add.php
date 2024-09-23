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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>จัดการข้อมูลราคาสินค้า</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
                                                        <option selected="selected" value=""> -- เลือกหน่วยนับ --</option>
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







    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
    </script>

</body>

</html>