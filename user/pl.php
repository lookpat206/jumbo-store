<?php

//สรุปรายการซื้อสินค้า user/pl.php

session_start();
// product list รายการซื้อสินค้า
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('_fn.php');
include('../admin/_fn_db.php');

// ตรวจสอบว่ามีการ login แล้วหรือไม่ และ u_id ถูกเก็บไว้ใน session หรือไม่
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit;
}

$u_id = isset($_SESSION['u_id']) ? intval($_SESSION['u_id']) : 0;
//print_r($u_id); // แสดงค่า u_id สำหรับดีบัก



// ดึงข้อมูลตลาดที่ซื้อสินค้า
$result = fetch_market_byuid($u_id);




?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>สรุปรายการซื้อสินค้า</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($result as $row): ?>
                    <div class="col-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo htmlspecialchars($row['mk_name']); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body collapse show"> <!-- show ให้เปิดโดย default -->
                                <table id="table_<?php echo $row['mk_id']; ?>" class="table table-bordered table-striped data-table">
                                    <thead>
                                        <tr class="table-info">
                                            <th width="5%">ซื้อสำเร็จ</th>
                                            <th width="20%">ร้านค้า</th>
                                            <th width="20%">สินค้า</th>
                                            <th width="10%">หน่วย</th>
                                            <th width="10%">จำนวน</th>
                                            <th width="10%">ราคา</th>
                                            <th width="10%">รวมเงิน</th>
                                            <th width="15%">แก้ไขบิล</th>
                                            <th width="5%">หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result2 = get_market_details($row['mk_id'], $u_id);
                                        $sum_total = 0;
                                        while ($item = mysqli_fetch_assoc($result2)):
                                            $sum_total += $item['total_price'];
                                        ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php if ($item['sp_status'] == 'ซื้อสำเร็จ'): ?>
                                                        <button class="btn btn-success btn-sm" disabled>ซื้อแล้ว</button>
                                                    <?php else: ?>
                                                        <button class="btn btn-secondary btn-sm" disabled>ยังไม่ได้ซื้อ</button>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($item['sp_name']); ?></td>
                                                <td><?php echo htmlspecialchars($item['pd_n']); ?></td>
                                                <td><?php echo htmlspecialchars($item['pu_name']); ?></td>
                                                <td><?php echo number_format($item['quantity'], 2); ?></td>
                                                <td><?php echo number_format($item['sp_price'], 2); ?></td>
                                                <td><?php echo number_format($item['total_price'], 2); ?></td>
                                                <td>
                                                    <a class="btn btn-danger btn-sm" href="pl_edit_po.php?pd_id=<?php echo $item['pd_id']; ?>">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning btn-sm" href="pl_edit_plan.php?pd_id=<?php echo $item['pd_id']; ?>">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-secondary">
                                            <td colspan="6" class="text-center"><strong>รวมเงิน</strong></td>
                                            <td colspan="3"><?php echo number_format($sum_total, 2); ?> บาท</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- /.content -->
</div>


<?php
include('_footer.php');
?>