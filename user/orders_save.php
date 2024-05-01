<?php 
include("_fn.php");

// รับ   DATE  จาก   oder.php
$c_id = $_POST["c_id"]; // ID-cust
$od_day = $_POST["od_day"]; //order day
$dv_day = $_POST["dv_day"]; //delivery day
$dv_time = $_POST["dv_time"]; // delivery time
$od_note = $_POST["od_note"]; //depatment

//exit($c_id . $od_day . $dv_day . $od_note);

order_add_save($c_id, $od_day, $dv_day, $dv_time, $od_note);


?>