<?php
session_start();
require_once '_fn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c_id = $_POST['c_id'];
    $od_day = $_POST['od_day'];
    $dv_day = $_POST['dv_day'];


    $po_id = create_po($c_id, $od_day, $dv_day);

    if ($po_id) {
        $_SESSION['od_id'] = $od_id;
        header("Location: od_detail.php"); // ไปเพิ่มรายการสินค้า
        exit;
    } else {
        echo "ไม่สามารถสร้างใบสั่งซื้อได้";
    }
}

print_r($_POST);


?>

<form method="post">
    <label>ลูกค้า:</label>
    <select name="c_id">
        <?php
        $customers = get_cust();
        while ($row = mysqli_fetch_assoc($customers)) {
            echo "<option value='{$row['c_id']}'>{$row['c_name']}</option>";
        }
        ?>
    </select><br>

    <label>วันที่สั่ง:</label>
    <input type="date" name="od_day" required><br>

    <label>วันที่ส่ง:</label>
    <input type="date" name="dv_day" required><br>

    <button type="submit">สร้างใบสั่งซื้อ</button>
</form>