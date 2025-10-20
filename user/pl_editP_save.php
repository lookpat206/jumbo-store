<?php
session_start();
include('_fn.php'); // ต้องมี $conn และฟังก์ชัน update_plan_syn/get_plan_id_by_shop

// รับค่าจากฟอร์ม
$shop_id = $_POST['shop_id'];
$mk_id   = $_POST['mk_id'];
$sp_id   = $_POST['sp_id'];
$u_id    = $_POST['u_id'];
$pd_id   = $_POST['pd_id'];
$note    = $_POST['note'];

// print_r($_POST);
// exit;

// เรียกฟังก์ชันอัปเดต
$result = update_plan_syn($shop_id, $mk_id, $sp_id, $u_id, $pd_id, $note);

// print_r($result);
// exit;
if ($result) {
    $_SESSION['notification'] = "อัปเดตข้อมูลแผนการซื้อเรียบร้อยแล้ว กรุณาตรวจสอบการมอบหมายผู้รับผิดชอบใหม่";
    header("Location: pl_edit_plan.php?pd_id=$pd_id");
    exit;
} else {
    echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');history.back();</script>";
}
