<?php

include('_header.php');
// include('_navbar.php');
// include('_sidebar_menu.php');
include('_fn.php');
include('../admin/_fn.php');


// GET od_id by fn-save
$od_id = $_GET['od_id'];
$order = fetch_orders_by_odid($od_id);

if ($order) {
    $c_id = $order['c_id']; // ดึงข้อมูล c_id จากผลลัพธ์
    // ใช้ $c_id ในการดำเนินการอื่นๆ ได้ตามต้องการ
} else {
    echo "ไม่พบข้อมูลการสั่งซื้อ";
}


$product = null;
if (isset($_POST['pd_id'])) {
    $pd_id = $_POST['pd_id'];
    $product = fetch_product_by_pd_id($pd_id, $c_id); // ใช้ฟังก์ชันเพื่อดึงข้อมูลสินค้า
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    $total = $product ? $product['price_sell'] * $quantity : 0;
}

echo $product;


$list = fetch_prod();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายการสั่งซื้อ</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body>
    <div class="content">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-6 mx-auto">
                        <!-- Order Form Card -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">เพิ่มรายการสั่งซื้อ</h3>
                            </div>
                            <form id="orderForm" method="post">
                                <input type="hidden" name="c_id" value="<?= htmlspecialchars($c_id) ?>">
                                <input type="hidden" name="od_id" value="<?= htmlspecialchars($od_id) ?>">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">

                                            <div class="form-group">
                                                <label for="productSelect">เลือกสินค้า:</label>
                                                <select id="productSelect" name="pd_id" class="form-control">
                                                    <option value="">-- กรุณาเลือกสินค้า --</option>
                                                    <?php foreach ($list as $prod) : ?>
                                                        <option value=" <?= $prod['pd_id'] ?>" <?= isset($pd_id) && $pd_id == $prod['pd_id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($prod['pd_n']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="quantity">จำนวน:</label>
                                                <input type="number" name="quantity" class="form-control" value="<?= isset($quantity) ? number_format($quantity, 2) : number_format(1, 2) ?>" min="0" step="0.01" onchange="this.form.submit()">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Save Button -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-danger">เพิ่ม</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Product List Table -->
                <div class="row">
                    <div class="col-6 mx-auto">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">ข้อมูลรายการสินค้า</h3>
                            </div>
                            <div class="card-body">
                                <!-- ตารางแสดงข้อมูลสินค้า -->
                                <div class="row">
                                    <div class="col-6 mx-auto">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="table-info">
                                                    <th width="5%">ลำดับ</th>
                                                    <th width="30%">รายการ</th>
                                                    <th width="10%">จำนวน</th>
                                                    <th width="10%">หน่วยนับ</th>
                                                    <th width="15%">ราคาต่อหน่วย</th>
                                                    <th width="30%">รวมเงิน</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($product) : ?>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><?= htmlspecialchars($product['pd_n']) ?></td>
                                                        <td><?= htmlspecialchars($quantity) ?></td>
                                                        <td><?= htmlspecialchars($product['pu_n']) ?></td>
                                                        <td><?= number_format($product['price_sell'], 2) ?></td>
                                                        <td><?= number_format($total, 2) ?></td>
                                                    </tr>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="6">กรุณาเลือกสินค้าเพื่อแสดงข้อมูล</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5" style="text-align:right">ผลรวมเงินทั้งหมด:</th>
                                                    <th><?= isset($total) ? number_format($total, 2) : '0.00' ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Date Range Picker -->
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('orderForm').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    this.submit();
                }
            });
        });
    </script>
</body>

</html>