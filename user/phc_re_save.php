<?php
session_start();
include('_fn.php');

// รับค่า POST (แนะนำเช็คด้วย)
$pd_id   = $_POST['pd_id'] ?? 0;
$shop_id = $_POST['shop_id'] ?? 0;
$pu_id   = $_POST['pu_id'] ?? 0;
$qty     = $_POST['qty'] ?? 0;
$note    = $_POST['note'] ?? 0;

if ($pd_id == 0 || $shop_id == 0 || $qty <= 0) {
    $_SESSION['msg'] = "ข้อมูลไม่ครบ";
    header("Location: phc_return.php");
    exit;
}
// 🔹 ต้องรับค่า return
$result = return_save($pd_id, $shop_id, $pu_id, $qty, $note);

// 🔹 เช็คผลลัพธ์
if ($result) {
    $_SESSION['msg'] = "คืนสินค้าสำเร็จ";
} else {
    $_SESSION['msg'] = "คืนสินค้าไม่สำเร็จ";
}

// 🔹 redirect กลับ
header("Location: pl.php");
exit;
