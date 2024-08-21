<?php
include("../admin/_fn.php");

// ดึงข้อมูลลูกค้า จาก TB-cust
$result2 = fetch_cust();
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
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper Content">
        <div class="Content">
            <div class="content-header"></div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Purchase order</h3>
                            </div>
                            <form action="orders_save.php" method="post" onsubmit="return validateForm()" name="myForm">
                                <div class="card-body">

                                    <!-- customer -->
                                    <div class="form-group">
                                        <label for="cust">Customer:</label>
                                        <select id="customerSelect" class="form-control select2" name="c_id" style="width: 100%;" onchange="this.form.submit()">
                                            <option selected="selected" value="">-- เลือกชื่อลูกค้า --</option>
                                            <?php foreach ($result2 as $row) { ?>
                                                <option value="<?= $row['c_id'] ?>" <?= isset($_POST['c_id']) && $_POST['c_id'] == $row['c_id'] ? 'selected' : '' ?>> <?= $row['c_name'] ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <!-- Order days: Date dd/mm/yyyy -->
                                    <div class="form-group">
                                        <label>Order days:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" name="od_day" class="form-control" placeholder="วัน/เดือน/ปี พ.ศ. " data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                        <small class="form-text text-danger">กรุณากรอกปีเป็น พุทธศักราช (เช่น 2567)</small>
                                    </div>

                                    <!-- Delivery days: Date dd/mm/yyyy -->
                                    <div class="form-group">
                                        <label>Delivery days:</label>
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" name="dv_day" class="form-control" placeholder="วัน/เดือน/ปี พ.ศ." data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
                                        </div>
                                        <small class="form-text text-danger">กรุณากรอกปีเป็น พุทธศักราช (เช่น 2567)</small>
                                    </div>

                                    <!-- Delivery time -->
                                    <div class="bootstrap-timepicker">
                                        <div class="form-group">
                                            <label>Delivery time:</label>
                                            <div class="input-group date" id="timepicker" data-target-input="nearest">
                                                <input type="text" name="dv_time" class="form-control datetimepicker-input" data-target="#timepicker" />
                                                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Department แผนก/ครัว -->
                                    <div class="form-group">
                                        <label for="dept">Department:</label>
                                        <select id="departmentSelect" class="form-control select2" name="d_id" style="width: 100%;">
                                            <option selected="selected" value="">-- เลือกแผนก/ครัว --</option>
                                            <?php
                                            if (isset($_POST['c_id']) && !empty($_POST['c_id'])) {
                                                // เรียกใช้ฟังก์ชัน fetch_depart_by_id เพื่อดึงข้อมูลแผนกตาม c_id ที่เลือก
                                                $departments = fetch_depart_by_id($_POST['c_id']);

                                                // สร้าง options สำหรับแผนก
                                                while ($row = mysqli_fetch_assoc($departments)) {
                                                    echo '<option value="' . $row['dp_id'] . '">' . $row['dp_name'] . '</option>';
                                                }

                                                // Free result set
                                                mysqli_free_result($departments);
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <!-- submit -->
                                <div>
                                    <button type="submit" class="btn btn-danger">save</button>
                                    <a href="index.php" class="btn btn-secondary">back</a>
                                </div>

                        </div>
                        <!-- /.card-body -->
                        </form>
                        <!--/.form -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col (left) -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
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

    <!-- Page specific script -->
    <script>
        // ตรวจสอบค่า " " ของ c_id ,od_day ,dv_day ,dv_time 
        function validateForm() {
            var c_id = document.forms["myForm"]["c_id"].value;
            var od_day = document.forms["myForm"]["od_day"].value;
            var dv_day = document.forms["myForm"]["dv_day"].value;
            var dv_time = document.forms["myForm"]["dv_time"].value;

            if (c_id === "" || od_day === "" || dv_day === "" || dv_time === "") {
                alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
                return false;
            }

            // ตรวจสอบเพิ่มเติมหากต้องการ
            return true; // ถ้าข้อมูลครบถ้วนและถูกต้อง
        }


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