<?php
//ใช้บันทึกข้อมูลสร้างใบสั่งซื้อสินค้า
include('../../_conf/conn.inc.php');

$cust_id=$_GET['cust_id'];
$od_date=$_GET['od_date'];
$od_note=$_GET['od_note'];

// บันทึกรายการสินค้า
$sql_order_add = "insert into orders(cust_id,od_date,od_note) values($cust_id,'$od_date','$od_note')";
mysqli_query($conn,$sql_order_add);
$od_id=mysqli_insert_id($conn);

header("Location:orders_detail.php?od_id=$od_id&cust_id=$cust_id&od_date=$od_date&od_note=$od_note");