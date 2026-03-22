<?php
//แสดงข้อมูลรายการซื้อสินค้าเสร็จแล้ว

session_start();

include('_header.php');
include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');
include('../admin/_fn.php');

// ตรวจสอบว่ามีการ login แล้วหรือไม่ และ u_id ถูกเก็บไว้ใน session หรือไม่
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit;
}
$u_id = isset($_SESSION['u_id']) ? intval($_SESSION['u_id']) : 0;
//print_r($u_id); // แสดงค่า u_id สำหรับดีบัก

$result2 = fetch_cust();



$c_id = intval($_POST['c_id'] ?? 0);
$dv_day = $_POST['dv_day'] ?? '';

$data = null;

// validate รูปแบบวันที่ dd/mm/yyyy
if ($c_id > 0 && preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dv_day)) {
    $data = get_delivery_list($c_id, $dv_day);
}






?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รายการสินค้าเตรียมจัดส่ง</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) จำนวนลูกค้า -->
            <div class="row">
                <!-- กล่องที่ 1: ค้นหาบิล -->
                <div class="col-6 mx-auto">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">ค้นหารายการสินค้า</h3>
                        </div>

                        <!-- form -->
                        <form action="" method="post">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">ชื่อลูกค้า</label>
                                    <select class="form-control select2 " name="c_id" style="width: 100%;">
                                        <option selected="selected" value="<?= $c_id ?>">--เลือกลูกค้า--</option>
                                        <?php foreach ($result2 as $row) { ?>
                                            <option value="<?= $row['c_id'] ?>"> <?= $row['c_abb'] ?> </option>
                                        <?php } ?>

                                    </select>

                                </div>

                                <!-- Date -->
                                <div class="form-group">
                                    <label>เลือกวันที่ส่ง :</label>

                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text"
                                            name="dv_day"
                                            class="form-control datetimepicker-input"
                                            data-target="#reservationdate"
                                            required />

                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!-- footer -->
                            <div class="card-footer">
                                <button type="submit" id="btn_summary" class="btn btn-danger">
                                    ค้นหา
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- กล่องที่ 2:จำนวนรายการ  -->
                <div class="col-6 mx-auto ">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="	fas fa-portrait"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">จำนวนรายการ</span>
                            <span class="info-box-number">

                            </span>

                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>

                    <!-- /.info-box -->
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="	fas fa-portrait"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">สินค้าพร้อมส่ง</span>
                            <span class="info-box-number">

                            </span>


                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="	fas fa-portrait"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">สินค้าค้างส่ง</span>



                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->


                </div>
                <!-- ./col -->


            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">รายการสินค้าของ(ชื่อลูกค้า) ประจำวันที่ (วันที่ส่ง)</h1>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="table-info">
                                        <th width="10%">ครบ</th>
                                        <th width="20%">รายการ</th>
                                        <th width="20%">จำนวน</th>

                                        <th width="10%">หน่วยนับ</th>
                                        <th width="10%">แผนก/ครัว</th>

                                        <th width="20%">สถานะ</th>
                                        <th width="10">ไม่ครบ</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if ($data && mysqli_num_rows($data) > 0) { ?>
                                        <?php while ($row = mysqli_fetch_assoc($data)) { ?>

                                            <tr>
                                                <td class="text-center">
                                                    <input type="checkbox"
                                                        class="chk-done"
                                                        data-sp="<?= $row['sp_id'] ?>"
                                                        data-od="<?= $row['od_id'] ?>"
                                                        data-stock="<?= $row['stock_id'] ?>"
                                                        data-qty="<?= $row['qty'] ?>"
                                                        <?= ($row['syn_stock'] == 1) ? 'checked disabled' : '' ?>>
                                                </td>

                                                <td><?= $row['pd_n'] ?></td>
                                                <td><?= $row['qty'] ?></td>
                                                <td><?= $row['pu_name'] ?></td>
                                                <td><?= $row['dp_name'] ?></td>
                                                <td><?= $row['sp_status'] ?? '-' ?></td>

                                                <td>
                                                    <a class="btn btn-danger">ไม่ครบ</a>
                                                </td>
                                            </tr>

                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>


                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>

<script>
    document.querySelectorAll('.chk-done').forEach(el => {
        el.addEventListener('change', function() {

            let shop_id = this.dataset.sp;
            let od_id = this.dataset.od;
            let stock_id = this.dataset.stock;
            let qty = this.dataset.qty;

            fetch('p_clist_save.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `sp_id=${sp_id}&od_id=${od_id}&stock_id=${stock_id}&qty=${qty}`
                })
                .then(res => res.text())
                .then(res => {
                    console.log(res);
                    this.disabled = true;
                });

        });
    });
</script>
<?php
include('_footer.php');
?>