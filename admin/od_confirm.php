<?php


session_start();

include('../user/_fn.php');

// ยืนยันใบสั่งซื้อ เปลี่ยนแปลงสถานะใบสั่งซื้อเป็น "สั่งซื้อสำเร็จ"

if (isset($_SESSION['od_id'])) {
    $od_id = $_SESSION['od_id'];
    print_r($od_id);
    // ตรวจสอบว่าใบสั่งซื้อมีอยู่ในฐานข้อมูลหรือไม่ 

    // เรียกฟังก์ชันยืนยันการสั่งซื้อ
    confirm_od($od_id);

    // เคลียร์ session ถ้าต้องการ
    unset($_SESSION['od_id']);

    // ย้ายไปหน้ารายการใบสั่งซื้อ
    echo "ยืนยันการสั่งซื้อเรียบร้อยแล้ว";
    header("Location: po.php?success=confirmed");
    //exit();
} else {
    echo "ไม่พบรหัสใบสั่งซื้อ";
}
?>








<?php
include('_footer.php');
?>