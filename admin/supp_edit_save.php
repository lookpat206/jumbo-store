<?php


include('_fn.php');
$sp_id = $_POST['sp_id'];
$sp_name = $_POST['sp_name'];
$pt_id = $_POST['pt_id'];
$sp_tel = $_POST['sp_tel'];

//echo "sp_id: $sp_id, sp_name: $sp_name, pt_id: $pt_id, sp_tel: $sp_tel<br>";

supp_edit($sp_id, $sp_name, $pt_id, $sp_tel);
