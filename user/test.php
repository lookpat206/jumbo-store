<?php
// require_once 'db.php';

// session_start();

// // เมื่อกดบันทึกใบสั่งซื้อ
// if (isset($_POST['save_order'])) {
//     $c_id = $_POST['c_id'];
//     $order_date = $_POST['order_date'];
//     $delivery_date = $_POST['delivery_date'];
//     $status = 'กำลังดำเนินการ';

//     $sql = "INSERT INTO po (c_id, order_date, delivery_date, status) VALUES (?, ?, ?, ?)";
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "isss", $c_id, $order_date, $delivery_date, $status);
//     mysqli_stmt_execute($stmt);
//     $po_id = mysqli_insert_id($conn);
//     $_SESSION['po_id'] = $po_id;

//     mysqli_stmt_close($stmt);
//     header("Location: po_add.php"); // reload เพื่อเพิ่มสินค้า
//     exit;
// }

// // เพิ่มสินค้าเข้า po_detail
// if (isset($_POST['add_item'])) {
//     $po_id = $_SESSION['po_id'];
//     $pd_id = $_POST['pd_id'];
//     $pu_id = $_POST['pu_id'];
//     $qty = $_POST['qty'];

//     // ดึงราคาขาย
//     $sql = "SELECT unit_price FROM price WHERE pd_id = ? AND pu_id = ?";
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "ii", $pd_id, $pu_id);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_bind_result($stmt, $unit_price);
//     mysqli_stmt_fetch($stmt);
//     mysqli_stmt_close($stmt);

//     // บันทึกลง po_detail
//     $sql = "INSERT INTO po_detail (po_id, pd_id, pu_id, qty, unit_price) VALUES (?, ?, ?, ?, ?)";
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "iiiid", $po_id, $pd_id, $pu_id, $qty, $unit_price);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);

//     header("Location: po_add.php");
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เพิ่มใบสั่งซื้อ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

    <h3>เพิ่มใบสั่งซื้อ</h3>

    <!-- ฟอร์มสร้างใบสั่งซื้อ -->
    <?php if (!isset($_SESSION['po_id'])): ?>
        <form method="POST">
            <div class="mb-2">
                <label>ลูกค้า</label>
                <select name="c_id" class="form-select" required>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM customers");
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<option value='{$row['c_id']}'>{$row['c_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-2">
                <label>วันที่สั่ง</label>
                <input type="date" name="order_date" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>วันที่จัดส่ง</label>
                <input type="date" name="delivery_date" class="form-control" required>
            </div>
            <button type="submit" name="save_order" class="btn btn-primary">สร้างใบสั่งซื้อ</button>
        </form>

    <?php else: ?>
        <hr>
        <!-- ฟอร์มเพิ่มรายการสินค้า -->
        <h5>เพิ่มสินค้า</h5>
        <form method="POST" class="row g-2">
            <div class="col-md-3">
                <select name="pd_id" class="form-select" required>
                    <option disabled selected>เลือกสินค้า</option>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM product");
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<option value='{$row['pd_id']}'>{$row['pd_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="pu_id" class="form-select" required>
                    <option disabled selected>หน่วยนับ</option>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM product_unit");
                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<option value='{$row['pu_id']}'>{$row['pu_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="qty" class="form-control" min="1" placeholder="จำนวน" required>
            </div>
            <div class="col-md-2">
                <button type="submit" name="add_item" class="btn btn-success">เพิ่มสินค้า</button>
            </div>
        </form>

        <!-- ตารางรายการสินค้าที่เพิ่ม -->
        <h5 class="mt-4">รายการสินค้า</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>สินค้า</th>
                    <th>หน่วยนับ</th>
                    <th>จำนวน</th>
                    <th>ราคา/หน่วย</th>
                    <th>รวม</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $po_id = $_SESSION['po_id'];
                $sql = "SELECT pd.pd_name, pu.pu_name, d.qty, d.unit_price, (d.qty * d.unit_price) AS total
                FROM po_detail d
                JOIN product pd ON d.pd_id = pd.pd_id
                JOIN product_unit pu ON d.pu_id = pu.pu_id
                WHERE d.po_id = $po_id";
                $res = mysqli_query($conn, $sql);
                $grand_total = 0;
                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                    <td>{$row['pd_name']}</td>
                    <td>{$row['pu_name']}</td>
                    <td>{$row['qty']}</td>
                    <td>" . number_format($row['unit_price'], 2) . "</td>
                    <td>" . number_format($row['total'], 2) . "</td>
                  </tr>";
                    $grand_total += $row['total'];
                }
                ?>
                <tr>
                    <td colspan="4" class="text-end"><strong>รวมทั้งหมด</strong></td>
                    <td><strong><?= number_format($grand_total, 2) ?></strong></td>
                </tr>
            </tbody>
        </table>

        <a href="po_confirm.php" class="btn btn-primary">เสร็จสิ้น</a>
    <?php endif; ?>

</body>

</html>