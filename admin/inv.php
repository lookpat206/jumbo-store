<?php
// inv.php ใช้เมื่อ ซื้อสินค้าเสร็จแล้ว รอจัดส่ง 
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('../user/_fn.php');
include('_fn.php');
include('_fn_db.php');

// รับค่าวันที่จาก GET หรือใช้วันที่ปัจจุบัน
// $dv_day = $_GET['dv_day'] ?? date('d/m/Y');

// // แปลงวันที่จาก mm/dd/yyyy → yyyy-mm-dd
// $date_parts = explode('/', $dv_day);
// if (count($date_parts) === 3) {
//     $formatted_date = $date_parts[2] . '-' . $date_parts[0] . '-' . $date_parts[1];
// } else {
//     $formatted_date = date('Y-m-d', strtotime($dv_day));
// }

// เรียกข้อมูลเฉพาะวันที่เลือก
$sp_list_result = fetch_sp_list();


// สรุปยอด
$totals = fetch_total_shopping();
$totals_cust = fetch_total_customers();
?>
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <h4 class="text display-4">รายการสินค้าเตรียมจัดส่ง</h4>
            <div class="row">
                <!-- สรุปยอดสั่งซื้อสินค้า -->
                <div class="col-6 mx-auto">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">สรุปรายการซื้อสินค้า</h3>

                        </div>
                        <!-- /.card-header -->
                        <form action="sp_add.php" method="post">
                            <div class="card-body">

                                <div class="form-group">
                                    <div>
                                        <label for="type">เลือกชื่อลูกค้า</label>
                                        <select class="form-control select2" name="sp_id" style="width: 100%;">
                                            <option selected="selected" value="">-- เลือกชื่อลูกค้า --</option>
                                            <?php foreach ($result2 as $row) { ?>
                                                <option value="<?= $row['sp_id'] ?>"> <?= $row['sp_name'] ?> </option>
                                            <?php } ?>

                                        </select>


                                    </div>

                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" id="btn_summary" class="btn btn-danger">
                                    ดึงข้อมูล
                                </button>

                            </div>
                        </form>




                    </div>
                    <!-- /.card -->
                </div>
                <!-- สินค้าค้างส่ง -->
                <div class="col-6 mx-auto">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">ราการสินค้าค้างส่ง</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link">
                                            ลูกค้า <span class="float-right badge bg-secondary"><?= $totals_cust['total_cust'] ?></span>
                                        </a>


                                    </li>
                                </ul>

                            </div>

                        </div>
                        <div class="card-footer">

                        </div>


                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>

        </div>
    </section>

    <!-- Main content: ตารางรายการ -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <!-- หัวตาราง รายการสินค้าเตรียมจัดส่ง -->
                        <div class="card-header">
                            <h3 class="card-title">รายการสินค้าของ </h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="ค้นหาสินค้า">
                                    <div class="input-group-append">
                                        <div class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="mailbox-controls">
                                <!-- Check all button -->
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                                </button>

                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <div class="float-right">
                                    1-50/200
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    <!-- /.btn-group -->
                                </div>
                                <!-- /.float-right -->
                            </div>
                            <div class="table-responsive mailbox-messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="icheck-primary">
                                                    <input type="checkbox" value="" id="check1">
                                                    <label for="check1"></label>
                                                </div>
                                            </td>
                                            <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                            <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                            <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                            </td>
                                            <td class="mailbox-attachment"></td>
                                            <td class="mailbox-date">5 mins ago</td>
                                        </tr>

                                    </tbody>
                                </table>
                                <!-- /.table -->
                            </div>
                            <!-- /.mail-box-messages -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer p-0">
                            <div class="mailbox-controls">
                                <!-- Check all button -->
                                <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                                    <i class="far fa-square"></i>
                                </button>

                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <div class="float-right">
                                    1-50/200
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-default btn-sm">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    <!-- /.btn-group -->
                                </div>
                                <!-- /.float-right -->
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('_footer.php'); ?>