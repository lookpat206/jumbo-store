<?php

include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('../user/_fn.php');
include('_fn.php');
include('_fn_db.php');


// ดึงข้อมูลจำนวนใบสั่งซื้อทั้งหมด
$total_od = fetch_totalod();
$unsynced_count = fetch_unsynced_count();



?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
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
                <!-- กล่องที่ 1: จำนวนออเดอร์ -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3><?= $total_od ?></h3>
                            <p>จำนวนออเดอร์</p>
                        </div>

                    </div>
                </div>
                <!-- ./col -->

                <!-- กล่องที่ 2: วันที่ปัจจุบัน -->
                <div class="col-lg-6 col-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h4>วันที่</h4>
                            <h1><?php echo date('d-m-Y'); ?></h>
                        </div>
                    </div>

                </div>
                <!-- ./col -->

                <!-- กล่องที่ 3: Icon รถเข็น และลิงก์ไปที่ orders.php -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $unsynced_count; ?></h3>
                            <p>ยอดค้างส่ง</p>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <?php
            // ตรวจสอบว่ามีการส่งค่าพารามิเตอร์ success มาหรือไม่
            if (isset($_GET['success']) && $_GET['success'] == 'confirmed') {
                echo '<div class="alert alert-success">ยืนยันการจัดส่งเรียบร้อยแล้ว</div>';
            }

            ?>

        </div><!-- /.container-fluid -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">ข้อมูลใบสั่งสินค้า</hๅ>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="table-info">
                                        <th width="10%">ลำดับ</th>
                                        <th width="10%">เลขที่ใบสั่งซื้อ</th>
                                        <th width="20%">ชื่อลูกค้า</th>
                                        <th width="10%">วันที่สั่ง</th>
                                        <th width="10%">วันที่ส่ง</th>
                                        <th width="20%">สถานะ</th>
                                        <th width="10%">รายละเอียด</th>
                                        <th width="10%">ยกเลิก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = get_orders();
                                    $i = 0;

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $i++;
                                            $od_id = $row['od_id'];
                                            $status = $row['od_status'];

                                            // ✅ ตั้งค่าสีตามสถานะ
                                            switch ($status) {
                                                case 'รอดำเนินการจัดซื้อ':
                                                    $badge_class = 'badge bg-orange '; // สีส้ม
                                                    break;
                                                case 'อยู่ระหว่างจัดส่ง':
                                                    $badge_class = 'badge bg-primary'; // สีน้ำเงิน
                                                    break;
                                                case 'รอชำระเงิน':
                                                    $badge_class = 'badge bg-warning'; // สีเหลือง
                                                    break;
                                                case 'ชำระเงินแล้ว':
                                                    $badge_class = 'badge bg-success'; // สีเขียว
                                                    break;
                                                case 'ยกเลิก':
                                                    $badge_class = 'badge bg-danger'; // สีแดง
                                                default:
                                                    $badge_class = 'badge bg-secondary'; // สีเทา
                                            }
                                    ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= htmlspecialchars($row['od_id']) ?></td>
                                                <td><?= htmlspecialchars($row['c_name']) ?></td>
                                                <td><?= htmlspecialchars($row['od_day']) ?></td>
                                                <td><?= htmlspecialchars($row['dv_day']) ?></td>
                                                <td>
                                                    <span class="<?= $badge_class ?>"><?= htmlspecialchars($status) ?></span>
                                                </td>
                                                <td>
                                                    <a type="button" class="btn btn-block btn-primary" href="po_detail.php?od_id=<?= $od_id ?>">รายละเอียด</a>
                                                </td>
                                                <td>
                                                    <a onclick="return confirm('คุณต้องการลบใบสั่งซื้อหรือไม่?')" type="button" class="btn btn-block btn-danger" href="po_delete.php?od_id=<?= $od_id ?>">ยกเลิกใบสั่ง</a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="8" class="text-center">ไม่พบข้อมูล</td></tr>';
                                    }
                                    ?>
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




<?php
include('_footer.php');
?>