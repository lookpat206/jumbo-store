<?php

//แก้ไขสถานะการซื้อสินค้าและหมายเหตุ
session_start();
?>
<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');
include('../admin/_fn.php');


//ดึงข้อมูล สถานที่ซื้อสินค้า, ร้านค้า , สินค้า , ผู้รับผิดชอบ เพื่อใช้ในการเลือกข้อมูล

$result2 = fetch_supp();
$result3 = fetch_prod();
$result4 = fetch_user();
$result5 = fetch_mark();


//รับค่า id จาก plan.php
$pd_id = $_GET['pd_id'];
$sp_id = $_GET['sp_id'];

$result = fetch_pl_plan_by_pdid($pd_id);
$row = mysqli_fetch_assoc($result);
$pd_name = $row['pd_n'];
$shop_id = $row['shop_id'];

// $result6 = fetch_sp_list_by_pdid($pd_id);
// $row1 = mysqli_fetch_assoc($result6);

//echo $pd_id . $sp_id;  //debug




?>

<div class="content">
    <!-- Content Header (Page header)  -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>แจ้งสาเหตุที่ไม่สามรถซื้อสินค้าได้</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="pl.php">กลับ</a></li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- แจ้งสถานะ -->
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">แจ้งสถานะ</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="pl_status_save.php" method="post">
                        <div class="row">


                            <div class="col-md-4">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">สถานะ :</h3>
                                    </div>
                                    <!-- /.card-header -->

                                    <input type="hidden" name="pd_id" value="<?= $pd_id ?>">
                                    <input type="hidden" name="sp_id" value="<?= $sp_id ?>">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">สถานะ:</label>
                                            <select class="form-control select2" name="sp_status" style="width: 100%;" id="status_select">
                                                <option selected="selected" value="รอสินค้า">รอสินค้า</option>
                                                <option value="เปลี่ยนผู้ซื้อ">เปลี่ยนผู้ซื้อ</option>
                                                <option value="เปลี่ยนร้าน">เปลี่ยนร้าน</option>
                                            </select>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->


                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4" id="buyer_card" style="display:none;">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">เปลี่ยนผู้ซื้อ</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>เลือกผู้ซื้อใหม่</label>
                                            <select class="form-control select2" name="u_id" style="width: 100%;">
                                                <option selected="selected" value="">-- เลือกผู้ซื้อใหม่ --</option>
                                                <?php foreach ($result4 as $row) { ?>
                                                    <option value="<?= $row['u_id'] ?>"> <?= $row['u_name'] ?> </option>
                                                <?php } ?>

                                            </select>
                                        </div>


                                    </div>
                                    <!-- /.card-body -->


                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4" id="shop_card" style="display:none;">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">เปลี่ยนร้าน</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <!-- /.card-header -->


                                    <div class="card-body">


                                        <!-- สถานที่ซื้อสินค้า -->
                                        <div class="form-group">
                                            <label for="type">สถานที่ซื้อสินค้า:</label>
                                            <select class="form-control select2" name="mk_id" style="width: 100%;">
                                                <option selected="selected" value="">-- เลือกข้อมูล --</option>
                                                <?php foreach ($result5 as $row) { ?>
                                                    <option value="<?= $row['mk_id'] ?>"> <?= $row['mk_name'] ?> </option>
                                                <?php } ?>

                                            </select>

                                        </div>

                                        <!--name ร้านค้า -->
                                        <div class="form-group">
                                            <label for="name">ชื่อร้านค้า:</label>
                                            <input type="text" name="sp_name" class="form-control" id="name" placeholder="ชื่อร้านค้า">
                                        </div>



                                        <!-- phone mask -->
                                        <div class="form-group">
                                            <label>เบอร์โทรศัพท์:</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" name="sp_tel" class="form-control" data-inputmask="'mask': '999-999-9999'" data-mask=" " type="text">
                                            </div><!-- /.input group -->

                                        </div><!-- /.form group -->




                                    </div> <!-- /.card-body -->




                                </div>
                                <!-- /.card -->

                            </div>
                            <!-- /.col -->

                            <button type="submit" class="btn btn-danger">บันทึก</button>

                        </div>
                        <!-- /.row -->
                    </form>


                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
            </div>
            <!-- /.card -->

        </div>
    </section>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->




<!-- /.content-wrapper -->
<footer class="main-footer">

</footer>

<script>
    $(document).ready(function() {

        function toggleForm() {

            let status = $('#status_select').val()

            $('#buyer_card').hide()
            $('#shop_card').hide()

            if (status === 'เปลี่ยนผู้ซื้อ') {
                $('#buyer_card').fadeIn()
            }

            if (status === 'เปลี่ยนร้าน') {
                $('#shop_card').fadeIn()
            }

        }

        toggleForm()

        $('#status_select').change(function() {
            toggleForm()
        })

    })
</script>
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





</body>

</html>