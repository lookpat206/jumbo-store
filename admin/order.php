<?php
// เริ่มต้นการสร้างใบสั่งซื้อใหม่

session_start();
include("../user/_fn.php");
include('_fn.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $c_id = $_POST['c_id'];
  $od_day = $_POST['od_day'];
  $dv_day = $_POST['dv_day'];
  $dv_time = $_POST['dv_time'];
  $od_note = $_POST['od_note'];


  $od_id = create_od($c_id, $od_day, $dv_day, $dv_time, $od_note);


  if ($od_id && $c_id) {
    $_SESSION['od_id'] = $od_id;
    $_SESSION['c_id'] = $c_id;
    if ($od_id && $c_id) {
      echo "สร้างใบสั่งซื้อเรียบร้อย: เลขที่ $od_id";
    } else {
      echo "ไม่สามารถสร้างใบสั่งซื้อได้";
    }
    header("Location: od_detail.php"); // ไปเพิ่มรายการสินค้า
    exit;
  } else {
    echo "ไม่สามารถสร้างใบสั่งซื้อได้";
  }
}

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

<body class="hold-transition sidebar-mini">
  <div class="wrapper Content">
    <div class="Content">
      <div class="content-header">

      </div>
    </div>




    <!-- Content Wrapper. Contains page content 
  <div class="content-wrapper">
    <!-- Content Header (Page header) 
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Advanced Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Advanced Form</li>
            </ol>
          </div>
        </div>
      </div> 
    </section>/.container-fluid -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 mx-auto">

            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Purchase order</h3>
              </div>
              <form method="post" onsubmit="return validateForm()" name="myForm">
                <div class="card-body">

                  <!-- customer -->
                  <div class="form-group">
                    <label for="cust">Customer:</label>

                    <select class="form-control select2" name="c_id" id="c_id" style="width: 100%;">
                      <option selected="selected" value="">-- เลือกชื่อลูกค้า --</option>
                      <?php
                      $customers = get_cust();
                      while ($row = mysqli_fetch_assoc($customers)) {
                        echo "<option value='{$row['c_id']}'>{$row['c_name']}</option>";
                      }
                      ?>

                    </select>

                  </div>

                  <!-- Order days: Date dd/mm/yyyy -->
                  <div class="form-group">
                    <label>Order days:</label>

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" name="od_day" id="order_date" class="form-control" placeholder="วัน/เดือน/ปี พ.ศ. " data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask required>
                    </div>
                    <!-- /.input group -->
                    <small class="form-text text-danger">กรุณากรอกปีเป็น ค.ศ. (เช่น 2025)</small>
                  </div>
                  <!-- /.form group -->

                  <!-- Delivery days:Date dd/mm/yyyy -->
                  <div class="form-group">
                    <label>Delivery days:</label>

                    <div class="input-group date">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" name="dv_day" id="delivery_date" class="form-control" placeholder="วัน/เดือน/ปี พ.ศ." data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask required>
                    </div>
                    <!-- /.input group -->
                    <small class="form-text text-danger">กรุณากรอกปีเป็น ค.ศ. (เช่น 2025)</small>
                  </div>
                  <!-- /.form group -->
                  <!-- Delivery time -->
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label>Delivery time:</label>

                      <div class="input-group date" id="timepicker" data-target-input="nearest">
                        <input type="text" name="dv_time" id="delivery_date" class="form-control datetimepicker-input" data-target="#timepicker" />
                        <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="far fa-clock"></i></div>
                        </div>
                      </div><!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                  </div>
                  <!-- /.bootstrap time picker -->
                  <!-- ครัว/แผนก -->
                  <div class="form-group">
                    <label for="">แผนก/ครัว:</label>

                    <select class="form-control" name="od_note" id="dp_id" style="width: 100%;">
                      <option value="">-- เลือกแผนก/ครัว --</option>
                    </select>
                  </div>


                  <!-- submit   -->
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

  <!-- ดึงข้อมูลแผนง/ครัวจากฐานข้อมูล -->
  <script>
    $('#c_id').on('change', function() {
      const c_id = $(this).val();
      $.post('order_update.php', {
        c_id: c_id
      }, function(data) {
        $('#dp_id').html(data);
      });
    });
  </script>
  <!-- เช็ควันที่สั่งซื้อและวันที่ส่ง -->
  <script>
    $(":input").inputmask();

    function parseDate(str) {
      const [day, month, year] = str.split('/');
      return new Date(`${year}-${month}-${day}`);
    }

    $('#order_date, #delivery_date').on('change', function() {
      const orderDate = parseDate($('#order_date').val());
      const deliveryDate = parseDate($('#delivery_date').val());

      if ($('#order_date').val() && $('#delivery_date').val()) {
        if (orderDate > deliveryDate) {
          alert('❌ วันที่สั่งต้องมาก่อนหรือเท่ากับวันที่ส่ง');
          $('#delivery_date').val('');
        }
      }
    });
  </script>
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