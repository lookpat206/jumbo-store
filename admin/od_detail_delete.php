<?php
include("../user/_fn.php");
session_start();

// ลบรายการสั่งซื้อเมือ่เพิ่มรายการสั่งซื้อผิดพลาด

if (isset($_GET['ord_id'])) {
    $ord_id = $_GET['ord_id'];
    //$od_id = $_GET['od_id'];
    // $c_id = $_GET['c_id'];

    if (delete_order_detail($ord_id)) {
        header("Location: od_detail.php?od_id=$od_id"); // กลับไปหน้าเดิม
        exit;
    } else {
        echo "ไม่สามารถลบรายการได้";
    }
} else {
    echo "ไม่มีรหัสรายการที่ต้องการลบ";
}
