<?php
include('_fn.php');

$mk_id = $_POST["mk_id"]; // id-สถานที่ซื้อสินค้า
$sp_name = $_POST["sp_name"]; // ชื่อร้านค้า
$sp_tel = $_POST["sp_tel"]; //เบอร์โทรศัพท์ร้านค้า


//exit($mk_id . $sp_name  . $sp_tel);

supp_add_save($mk_id, $sp_name, $sp_tel);
