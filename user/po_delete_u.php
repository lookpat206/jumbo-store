<?php
session_start();
require_once '_fn.php';

if (isset($_GET['od_id'])) {

    $od_id = $_GET['od_id'];
    print_r($od_id);
    if (delete_po($od_id)) {
        echo "ลบใบสั่งซื้อสำเร็จ";
        header("Location:po.php");
        //exit;
    } else {
        echo "เกิดข้อผิดพลาดในการลบใบสั่งซื้อ";
    }
}
