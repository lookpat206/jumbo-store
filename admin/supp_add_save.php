<?php 
include('_fn.php');

$sp_name = $_POST["sp_name"]; // ชื่อร้านค้า
$pt_id = $_POST["pt_id"]; //id -ประเภทสินค้า
$mk_id = $_POST["mk_id"]; // id-สถานที่ซื้อสินค้า
$sp_tel = $_POST["sp_tel"]; //เบอร์โทรศัพท์ร้านค้า


//exit($sp_name . $pt_id . $mk_id . $sp_tel);

supp_add_save($sp_name,$pt_id,$mk_id,$sp_tel);

?>