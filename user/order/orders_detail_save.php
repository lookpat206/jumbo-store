<?php
//ใช้บันทึกข้อมูลรายการสินค้า รับข้อมูลจาก order_detail.php
include('../../_conf/conn.inc.php');

// Get values from query strings
$od_id=$_POST['od_id'];
$cust_id=$_POST['cust_id'];
$od_date=$_POST['od_date'];
$od_note=$_POST['od_note'];

$prod_id=$_POST['prod_id'];
$ord_quantity=$_POST['ord_quantity'];

// query product price from table product
$sql="select prod_price from product where prod_id=$prod_id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$prod_price=$row['prod_price'];

// ord_id รหัสรายละเอียดใบส่งสินค้า	
// prod_id
// รหัสสินค้า	ord_quantity
// จำนวนสินค้า	ord_price
// ราคาสินค้า		od_id
// รหัสใบส่งสินค้า

$sql="insert into orders_detail(od_id,prod_id,ord_quantity,ord_price) values($od_id,$prod_id,$ord_quantity,$prod_price)";
//exit($sql);
mysqli_query($conn,$sql);

header("Location:orders_detail.php?od_id=$od_id&cust_id=$cust_id&od_date=$od_date&od_note=$od_note");