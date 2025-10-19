<?php
//เปลี่ยนข้อมูลแผนการซื้อ : ร้านค้า ผู้รับผิดชอบ ตลาด
//แก้ไขสถานะการซื้อสินค้าและหมายเหตุ
session_start();
?>
<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');
include('../admin/_fn.php');

//ดึงข้อมูล สถานที่ซื้อสินค้า , ร้านค้า , สินค้า , ผู้รับผิดชอบ เพื่อใช้ในการเลือกข้อมูล

$result2 = fetch_supp();
$result3 = fetch_prod();
$result4 = fetch_user();
$result5 = fetch_mark();


//รับค่า id จาก plan.php
$pd_id = $_GET['pd_id'];
//$plan_id = $_GET['plan_id'];

$result = fetch_pl_plan_by_pdid($pd_id);
$row = mysqli_fetch_assoc($result);
$pd_name = $row['pd_n'];

// $result6 = fetch_sp_list_by_pdid($pd_id);
// $row1 = mysqli_fetch_assoc($result6);

//echo $pd_id . $sp_id;  //debug




?>

<div class="content">
    <!-- Content Header (Page header)  -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-9 mx-auto text-center">
                    <h1>แก้ไขแผนการซื้อสินค้า</h1>
                </div>
                <div class="col-3 mx-auto">
                    <a href="pl.php" class="btn btn-secondary">กลับ</a>
                </div>


            </div>
        </div> <!--.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php if (!empty($result)): ?>
                    <?php foreach ($result as $row): ?>
                        <div class="col-md-9 mx-auto">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        แก้ไขแผนการซื้อ <?php echo $pd_name ?> ของ <?php echo htmlspecialchars($row['c_abb']); ?>
                                    </h3>
                                    <div class="card-tools">
                                        <!-- collapse ปุ่ม -->
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- เพิ่ม class collapse show เพื่อให้เปิดตอนโหลด -->
                                <div class="card-body collapse show">
                                    <form action="pl_editPO_save.php" method="post">
                                        <input type="hidden" name="shop_id" value="<?php echo htmlspecialchars($row['shop_id']); ?>">

                                        <div class="row">
                                            <!-- ซ้าย -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label>ตลาด</label>
                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['mk_name']); ?>" readonly>
                                                </div>

                                                <div class="form-group">
                                                    <label>ร้านค้า</label>
                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['sp_name']); ?>" readonly>
                                                </div>
                                            </div>

                                            <!-- ขวา -->
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="type">ผู้รับผิดชอบ :</label>
                                                    <select class="form-control select2" name="u_id" style="width: 100%;">
                                                        <option selected="selected" value="<?= $row['u_id'] ?>">--<?= $row['u_name'] ?>--</option>
                                                        <?php foreach ($result4 as $row) { ?>
                                                            <option value="<?= $row['u_id'] ?>"> <?= $row['u_name'] ?> </option>
                                                        <?php } ?>

                                                    </select>

                                                </div>

                                                <div class="form-group">
                                                    <label>หมายเหตุ</label>
                                                    <textarea class="form-control " name="note" placeholder="เปลี่ยนสถานที่ซื้อ / ร้านค้า..."></textarea>

                                                </div>


                                            </div>
                                        </div>

                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-danger mr-2">บันทึก</button>

                                        </div>
                                    </form>
                                </div> <!-- /.card-body -->
                            </div> <!-- /.card -->
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-6 text-center">
                        <p>ไม่พบรายการซื้อสินค้า</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->




<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
    </div>
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
<!-- jQuery UI 1.11.4 -->
<!-- <script src="plugins/jquery-ui/jquery-ui.min.js"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DataTables  & Plugins ห้ามตัดทิ้ง-->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- เพิ่ม SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    document.querySelectorAll(".btn-save").forEach(btn => {
        btn.addEventListener("click", function() {
            const shop_id = this.dataset.id;
            const qty = document.querySelector(`.qty[data-id="${shop_id}"]`).value;
            const price = document.querySelector(`.price[data-id="${shop_id}"]`).value;

            Swal.fire({
                title: "ยืนยันการบันทึก?",
                text: "ต้องการเปลี่ยนสถานะเป็น 'ซื้อสำเร็จ' หรือไม่",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "ใช่, บันทึกเลย!",
                cancelButtonText: "ยกเลิก",
            }).then(result => {
                if (result.isConfirmed) {
                    fetch("pl_editPO_save.php", {
                            method: "POST",
                            body: new URLSearchParams({
                                shop_id: shop_id,
                                qty: qty,
                                price: price
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === "success") {
                                Swal.fire("สำเร็จ!", "อัปเดตข้อมูลเรียบร้อย", "success").then(() => location.reload());
                            } else {
                                Swal.fire("ผิดพลาด!", "ไม่สามารถบันทึกได้", "error");
                            }
                        });
                }
            });
        });
    });
</script>


<!-- Page specific script -->
<script>
    $(function() {
        bsCustomFileInput.init();
    });
    $(function() {
        $("#example1").DataTable({
            //"lengthChange": true กำหนดจำนวนหน้า,
            //"autoWidth": false ความกว้างของคอลัม
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "aaSorting": [
                [0, "desc"]
            ],
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });



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