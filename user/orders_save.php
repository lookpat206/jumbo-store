<?php
//บันทึกใบสั่งซื้อใหม่ โดยมีการตรวจสอบข้อมูลวันที่ และค่าตัวแปรที่จำเป็น

include("_fn.php");
session_start();


// รับข้อมูลจากฟอร์ม
$c_id    = $_POST["c_id"];     // รหัสลูกค้า
$od_day  = $_POST["od_day"];   // วันที่สั่ง (dd/mm/yyyy)
$dv_day  = $_POST["dv_day"];   // วันที่ส่ง (dd/mm/yyyy)
$dv_time = $_POST["dv_time"];  // เวลาส่ง
$od_note = $_POST["od_note"];  // รหัสแผนก/ครัว

// --- ตรวจสอบรูปแบบวันที่ และแปลงเป็น Y-m-d ---
function convert_date($date_str)
{
    $parts = explode('/', $date_str); // แยก dd/mm/yyyy
    if (count($parts) === 3) {
        return $parts[2] . '-' . $parts[1] . '-' . $parts[0]; // yyyy-mm-dd
    }
    return null;
}

$od_day_converted = convert_date($od_day);
$dv_day_converted = convert_date($dv_day);

// --- ตรวจสอบว่ากรอกข้อมูลครบหรือไม่ ---
if (empty($c_id) || empty($od_day_converted) || empty($dv_day_converted) || empty($dv_time) || empty($od_note)) {
    exit("⚠️ กรุณากรอกข้อมูลให้ครบถ้วน");
}

// --- ตรวจสอบว่า od_day ต้องมาก่อน dv_day ---
if (strtotime($od_day_converted) > strtotime($dv_day_converted)) {
    exit("❌ วันที่สั่งต้องน้อยกว่าหรือเท่ากับวันที่ส่ง");
}

// --- เรียกฟังก์ชันเพิ่มข้อมูล ---
order_add_save($c_id, $od_day, $dv_day, $dv_time, $od_note);
