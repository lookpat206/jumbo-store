<?php
session_start();
require_once '_fn.php';


if (!isset($_SESSION['od_id']) || !isset($_SESSION['c_id'])) {
    echo "กรุณาสร้างใบสั่งซื้อก่อน";

    exit;
}

$od_id = $_SESSION['od_id'];
$c_id = $_SESSION['c_id'];
$alert = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pd_id = $_POST['pd_id'];
    $pu_id = $_POST['pu_id'];
    $qty = $_POST['qty'];
    $c_id = $_POST['c_id'];

    $price_s = get_price($pd_id, $pu_id, $c_id);
    print_r($price_s);
    // ตรวจสอบว่าเจอราคาหรือไม่
    // เช็คราคาว่าดึงได้ไหม
    if ($price_s === false) {
        $alert = "ไม่สามารถเพิ่มสินค้าได้: ไม่พบราคาสำหรับสินค้านี้ หน่วยนับ หรือรหัสลูกค้า";
    } else {
        $total = $price_s * $qty;
        if (add_po_detail($od_id, $pd_id, $pu_id, $qty, $price_s, $total)) {
            $alert = "เพิ่มสินค้าเรียบร้อยแล้ว";
        } else {
            $alert = "เกิดข้อผิดพลาดในการเพิ่มสินค้า";
        }
    }
}
print_r($_POST);
?>

<form method="post">
    <label>สินค้า:</label>
    <input type="hidden" name="c_id" value="<?= $c_id ?>">
    <select name="pd_id">
        <?php
        $products = get_prod();
        while ($row = mysqli_fetch_assoc($products)) {
            echo "<option value='{$row['pd_id']}'>{$row['pd_n']}</option>";
        }
        ?>
    </select><br>

    <label>หน่วยนับ:</label>
    <select name="pu_id">
        <?php
        $units = get_units();
        while ($row = mysqli_fetch_assoc($units)) {
            echo "<option value='{$row['pu_id']}'>{$row['pu_name']}</option>";
        }
        ?>
    </select><br>

    <label>จำนวน:</label>
    <input type="number" name="qty" step="0.01" min="0" required><br>

    <button type="submit">เพิ่มรายการสินค้า</button>
</form>

<!-- ตารางแสดงรายการสินค้าในใบสั่งซื้อนี้ -->

<?php if (!empty($alert)) : ?>
    <div class="alert alert-warning">
        <?= $alert ?>
    </div>
<?php endif; ?>
<h3>📦 รายการสินค้าในใบสั่งซื้อ</h3>
<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ลำดับ</th>
            <th>สินค้า</th>
            <th>หน่วยนับ</th>
            <th>จำนวน</th>
            <th>ราคาต่อหน่วย</th>
            <th>รวม</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $details = get_orders_detail($od_id);
        $i = 0;
        $grand_total = 0;

        while ($row = mysqli_fetch_assoc($details)) {
            $i++;
            $grand_total += $row['total'];
            echo "<tr>
                <td>{$i}</td>
                <td>{$row['pd_n']}</td>
                <td>{$row['pu_name']}</td>
                <td>{$row['qty']}</td>
                <td>" . number_format($row['price_s'], 2) . "</td>
                <td>" . number_format($row['total'], 2) . "</td>
            </tr>";
        }

        if ($i == 0) {
            echo "<tr><td colspan='6'>ยังไม่มีรายการสินค้า</td></tr>";
        }
        ?>
    </tbody>
    <?php if ($i > 0): ?>
        <tfoot>
            <tr>
                <td colspan="5" align="right"><strong>รวมทั้งสิ้น</strong></td>
                <td><strong><?= number_format($grand_total, 2) ?></strong></td>
            </tr>
        </tfoot>
    <?php endif; ?>
</table>

<br>
<a href="od_confirm.php" class="btn btn-success" onclick="return confirm('ยืนยันการสั่งซื้อหรือไม่?')">
    ยืนยันการสั่งซื้อ
</a>