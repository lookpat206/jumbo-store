<?php

include('_fn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = intval($_POST['order_id']);

    // print_r($order_id);
    // exit();

    // เรียกฟังก์ชันตัดสต็อก + เปลี่ยนสถานะ
    $result = update_stock_after_order($order_id);

    if ($result === true) {
        // Redirect กลับไปหน้า po.php พร้อมพารามิเตอร์ success (optional)
        header("Location: po.php?success=1");
        exit(); // ห้ามลืม exit() หลัง header()
    } else {
        // กรณีเกิดข้อผิดพลาด
        header("Location: po.php?error=" . urlencode($result));
        exit();
    }
}
