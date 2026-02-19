<?php

//แก้ไขข้อมูลราคาสินค้าในคำสั่งซื้อ

include '_fn.php'; // สมมุติว่าเก็บฟังก์ชันไว้ในไฟล์นี้




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $shop_id    = $_POST['shop_id'];
    $pd_id      = $_POST['pd_id'];
    $shop_qty   = $_POST['shop_qty'];
    $shop_price = $_POST['shop_price'];
    $sp_status  = $_POST['sp_status'];
    $stock_date = date('Y-m-d'); // วันที่ปัจจุบัน

    // echo "<pre>";
    // print_r($_POST);

    if (update_purchase_and_stock($shop_id,  $shop_qty, $shop_price, $sp_status, $stock_date)) {
        echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location='pl_edit_po.php?pd_id=$pd_id';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการบันทึก'); history.back();</script>";
    }
}
