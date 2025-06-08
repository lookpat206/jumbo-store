<?php
include('../user/_fn.php');

// ยืนยันใบสั่งซื้อ เปลี่ยนสถานะเป็น "จัดส่งสำเร็จ"
if (isset($_GET['od_id'])) {
    $od_id = $_GET['od_id']; // รับค่าจาก URL

    // เรียกฟังก์ชันเพื่อยืนยัน
    confirm_po($od_id);

    // ย้ายไปหน้าหลัก
    header("Location: po.php?success=confirmed");
    exit();
} else {
    echo "ไม่พบรหัสใบสั่งซื้อ";
}
