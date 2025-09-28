<?php
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
print_r($u_id); // แสดงค่า u_id สำหรับดีบัก



$mk = fetch_market_byuid($u_id); // ดึงข้อมูลตลาดที่ซื้อสินค้า
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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo htmlspecialchars($row['mk_name']); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-target="#market<?php echo $row['mk_id']; ?>">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Body: collapse -->
                            <div class="card-body collapse" id="market<?php echo $row['mk_id']; ?>">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-info">
                                            <th width="5%">ซื้อสำเร็จ</th>
                                            <th width="5%">ร้านค้า</th>
                                            <th width="15%">สินค้า</th>
                                            <th width="10%">จำนวน</th>
                                            <th width="10%">ราคา</th>
                                            <th width="15%">รวมเงิน</th>
                                            <th width="10%">หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result2 = get_market_details($row['mk_id'], $u_id);
                                        $sum_total = 0;
                                        while ($row = mysqli_fetch_assoc($result2)):
                                            $sum_total += $row['total_price'];
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox">

                                                        </div>
                                                    </div>

                                                </td>
                                                <td><?php echo htmlspecialchars($row['sp_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['pd_n']); ?></td>
                                                <td><?php echo number_format($row['quantity'], 2); ?></td>
                                                <td><?php echo number_format($row['sp_price'], 2); ?></td>
                                                <td><?php echo number_format($row['total_price'], 2); ?></td>
                                                <td>
                                                    <a onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm" href="supp_delete.php?sp_id=<?= $row['sp_id'] ?>">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            <?php endwhile; ?>
                                            <tr class="total-row">
                                                <td colspan="5">รวมเงิน</td>
                                                <td colspan="2"><?php echo number_format($sum_total, 2); ?> บาท</td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer">

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