<?php
// inv.php
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
            <h4 class="text display-4">รายการซื้อสำเร็จ</h4>

            <div class="row">



                <!-- แสดงวันที่และสรุป -->
                <div class="col-6 mx-auto">
                    <div class="card card-widget">
                        <div class="widget-user-header bg-green text-center">
                            <div class="inner">
                                <h5>วันที่ส่งสินค้า</h5>
                                <h1><?php echo date('d-m-Y'); ?></h1>
                            </div>
                        </div>
                        <div class="card-footer p-0">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link">ลูกค้า <span class="float-right badge bg-secondary"><?= $totals_cust['total_cust'] ?></span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link">ตลาด <span class="float-right badge bg-secondary"><?= $totals['total_markets'] ?></span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link">ร้านค้า <span class="float-right badge bg-secondary"><?= $totals['total_suppliers'] ?></span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link">ผู้รับผิดชอบ <span class="float-right badge bg-secondary"><?= $totals['total_users'] ?></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content: ตารางรายการ -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">รายการซื้อสำเร็จ</h1>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="table-info" style=" text-align: center">
                                        <th>ลำดับ</th>
                                        <th>ตลาด</th>
                                        <th>ร้านค้า</th>
                                        <th>ผู้รับผิดชอบ</th>
                                        <th>สินค้า</th>
                                        <th>จำนวนสั่ง</th>

                                        <th>จำนวนซื้อ</th>
                                        <th>หน่วยนับ</th>
                                        <th>ราคา</th>
                                        <th>รวม</th>
                                        <th>วันที่ซื้อ</th>
                                        <th>รายละเอียด</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $grand_total = 0;
                                    while ($row = mysqli_fetch_assoc($sp_list_result)):
                                        $i++;
                                        $grand_total += $row['total_price'];
                                    ?>
                                        <tr>
                                            <td><?= $i  ?></td>
                                            <td><?= htmlspecialchars($row['mk_name']) ?></td>
                                            <td><?= htmlspecialchars($row['sp_name']) ?></td>
                                            <td><?= htmlspecialchars($row['u_name']) ?></td>
                                            <td><?= htmlspecialchars($row['pd_n']) ?></td>
                                            <td><?= number_format($row['qty'], 2) ?></td>
                                            <td><?= number_format($row['shop_qty'], 2) ?></td>
                                            <td><?= htmlspecialchars($row['pu_name']) ?></td>
                                            <td><?= number_format($row['shop_price'], 2) ?></td>
                                            <td><?= number_format($row['total_price'], 2) ?></td>
                                            <td><?= htmlspecialchars($row['update_at']) ?></td>
                                            <td>
                                                <a class="btn btn-warning btn-sm" href="inv_edit.php?pd_id=<?= $row['pd_id'] ?>&od_id=<?= $row['od_id'] ?>">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php if ($i == 0): ?>
                                        <tr>
                                            <td colspan="12" class="text-center">ยังไม่มีรายการสินค้า</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <?php if ($i > 0): ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="9" align="right"><strong>รวมทั้งสิ้น</strong></td>
                                            <td colspan="3"><strong><?= number_format($grand_total, 2) ?></strong></td>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include('_footer.php'); ?>