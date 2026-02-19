<?php
session_start();
require_once '_fn.php';

//เพิ่มรายการสั่งซื้อและแสดงข้อมูลการสั่งซื้อ

// ตรวจสอบว่ามีการสร้างใบสั่งซื้อหรือไม่


if (!isset($_SESSION['od_id']) || !isset($_SESSION['c_id'])) {
    echo "กรุณาสร้างใบสั่งซื้อก่อน";

    exit;
}

$od_id = $_SESSION['od_id'];
$c_id = $_SESSION['c_id'];
$alert = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pd_id = $_POST['pd_id'];
    $pu_id = $_POST['pu_id'];
    $qty = $_POST['qty'];
    $c_id = $_POST['c_id'];


    $price_s = get_price($pd_id, $pu_id, $c_id);
    //print_r($price_s);
    // ตรวจสอบว่าเจอราคาหรือไม่
    // เช็คราคาว่าดึงได้ไหม
    if ($price_s === false) {
        $alert = "ไม่สามารถเพิ่มสินค้าได้: ไม่พบราคาสำหรับสินค้านี้ หน่วยนับ หรือรหัสลูกค้า";
    } else {
        $total = $price_s * $qty;
        if (add_po_detail($od_id, $pd_id, $pu_id, $qty, $price_s, $total)) {
            $alert = "เพิ่มสินค้าเรียบร้อยแล้ว";
        } else {
            $alert = "เกิดข้อผิดพลาดในการเพิ่มสินค้า";
        }
    }
}

//include('_header.php');
//print_r($_POST);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ใบสั่งซื้อสินค้า</title>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

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
                                    <h3 class="card-title">เพิ่มรายการสินค้า</h3>
                                </div>
                                <form method="post">
                                    <input type="hidden" name="c_id" value="<?= $c_id ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- ชื่อสินค้า -->
                                                <div class="form-group">
                                                    <label>สินค้า</label>
                                                    <select id="pd_id" name="pd_id" class="form-control select2">
                                                        <!-- <option value="">-- เลือกสินค้า --</option> -->
                                                        <?php
                                                        $products = get_products_by_customer($c_id);
                                                        foreach ($products as $prod) {
                                                            echo "<option value='{$prod['pd_id']}'>{$prod['pd_n']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <!-- เลือกหน่วยนับ -->
                                                <div class="form-group">
                                                    <label>หน่วยนับ</label>
                                                    <select id="pu_id" name="pu_id" class="form-control select2">
                                                        <option value="">-- เลือกหน่วยนับ --</option>
                                                    </select>
                                                </div>


                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">

                                                    <!-- จำนวนสินค้า -->
                                                    <div class="mb-3">
                                                        <label>จำนวน : </label>
                                                        <input type=" number" class="form-control" name="qty" step="0.01" min="0" required>
                                                        <small class="form-text text-danger">ใส่ทศนิยม 2 ตำแหน่ง</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--  /.row -->
                                    </div> <!-- /.card-body -->
                                    <!-- บันทึก -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-danger">เพิ่มรายการสินค้า</button>

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
                                    <?php if (!empty($alert)) : ?>
                                        <div class="alert alert-warning">
                                            <?= $alert ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="table-info">
                                                <th width="10%">ลำดับ</th>
                                                <th width="40%">สินค้า</th>
                                                <th width="20%">หน่วยนับ</th>
                                                <th width="20%">จำนวน</th>
                                                <th width="20%">ราคาต่อหน่วย</th>
                                                <th width="20%">รวม</th>
                                                <th width="10%">ลบรายการ</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $details = get_orders_detail($od_id);
                                            $i = 0;
                                            $grand_total = 0;
                                            //$ord_id = $row['ord_id']; // สมมติชื่อ PK ในตารางคือ odr_id


                                            while ($row = mysqli_fetch_assoc($details)) {
                                                $i++;
                                                $grand_total += $row['total'];
                                                $ord_id = $row['ord_id']; // สมมติชื่อ PK ในตารางคือ ord_id

                                                echo "<tr>
                                                        <td>{$i}</td>
                                                        <td>{$row['pd_n']}</td>
                                                        <td>{$row['pu_name']}</td>
                                                        <td>{$row['qty']}</td>
                                                        <td>" . number_format($row['price_s'], 2) . "</td>
                                                        <td>" . number_format($row['total'], 2) . "</td>
                                                        <td>
                                                            <a href='od_detail_delete.php?ord_id=$ord_id' class='btn btn-danger btn-sm'
                                                                onclick=\"return confirm('คุณต้องการลบรายการนี้หรือไม่?')\">
                                                                <i class='far fa-trash-alt'></i> ลบ
                                                            </a>
                                                        </td>
                                                    </tr>";
                                            }

                                            if ($i == 0) {
                                                echo "<tr><td colspan='7'>ยังไม่มีรายการสินค้า</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                        <?php if ($i > 0): ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" align="right"><strong>รวมทั้งสิ้น</strong></td>
                                                    <td><strong><?= number_format($grand_total, 2) ?></strong></td>
                                                </tr>
                                            </tfoot>
                                        <?php endif; ?>
                                    </table>



                                </div><!-- /.card-body -->
                                <div class="card-footer">
                                    <a href="od_confirm.php" class="btn btn-success" onclick="return confirm('ยืนยันการสั่งซื้อหรือไม่?')">
                                        ยืนยันการสั่งซื้อ
                                    </a>
                                </div>

                            </div><!-- /.card -->

                        </div> <!-- /.col -->

                    </div><!-- /.row -->
                </div>
        </div>
        <!-- /.container-fluid -->

        </section>
        </div> <!-- /.content -->

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
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
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>

        <!-- dynamic unit by TB-pri_detail -->
        <script>
            $(document).ready(function() {
                $('#pd_id').change(function() {
                    var pd_id = $(this).val();
                    var c_id = $('input[name="c_id"]').val(); // ดึง c_id จาก input ที่ซ่อนอยู่

                    if (pd_id) {
                        $.ajax({
                            type: 'POST',
                            url: 'od_DAdd_unit.php',
                            data: {
                                pd_id: pd_id,
                                c_id: c_id
                            },
                            dataType: 'json',
                            success: function(data) {
                                $('#pu_id').empty();
                                $('#pu_id').append('<option value="">-- เลือกหน่วยนับ --</option>');
                                $.each(data, function(index, unit) {
                                    $('#pu_id').append('<option value="' + unit.pu_id + '">' + unit.pu_name + '</option>');
                                });
                            },
                            error: function() {
                                alert('เกิดข้อผิดพลาดในการดึงข้อมูลหน่วยนับ');
                            }
                        });
                    } else {
                        $('#pu_id').empty();
                        $('#pu_id').append('<option value="">-- เลือกหน่วยนับ --</option>');
                    }
                });
            });
        </script>


        <!-- Page specific script -->
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
            // BS-Stepper Init
            document.addEventListener('DOMContentLoaded', function() {
                window.stepper = new Stepper(document.querySelector('.bs-stepper'))
            })

            // DropzoneJS Demo Code Start
            Dropzone.autoDiscover = false

            // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
            var previewNode = document.querySelector("#template")
            previewNode.id = ""
            var previewTemplate = previewNode.parentNode.innerHTML
            previewNode.parentNode.removeChild(previewNode)

            var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
                url: "/target-url", // Set the url
                thumbnailWidth: 80,
                thumbnailHeight: 80,
                parallelUploads: 20,
                previewTemplate: previewTemplate,
                autoQueue: false, // Make sure the files aren't queued until manually added
                previewsContainer: "#previews", // Define the container to display the previews
                clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
            })

            myDropzone.on("addedfile", function(file) {
                // Hookup the start button
                file.previewElement.querySelector(".start").onclick = function() {
                    myDropzone.enqueueFile(file)
                }
            })

            // Update the total progress bar
            myDropzone.on("totaluploadprogress", function(progress) {
                document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
            })

            myDropzone.on("sending", function(file) {
                // Show the total progress bar when upload starts
                document.querySelector("#total-progress").style.opacity = "1"
                // And disable the start button
                file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
            })

            // Hide the total progress bar when nothing's uploading anymore
            myDropzone.on("queuecomplete", function(progress) {
                document.querySelector("#total-progress").style.opacity = "0"
            })

            // Setup the buttons for all transfers
            // The "add files" button doesn't need to be setup because the config
            // `clickable` has already been specified.
            document.querySelector("#actions .start").onclick = function() {
                myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
            }
            document.querySelector("#actions .cancel").onclick = function() {
                myDropzone.removeAllFiles(true)
            }
            // DropzoneJS Demo Code End
        </script>
    </body>

</html>