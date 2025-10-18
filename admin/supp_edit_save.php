<?php


include('_fn.php');
$sp_id = $_POST['sp_id'];
$mk_id = $_POST['mk_id'];
$sp_name = $_POST['sp_name'];
$sp_tel = $_POST['sp_tel'];

//echo "sp_id: $sp_id, sp_name: $sp_name, mk_id: $mk_id, sp_tel: $sp_tel<br>";

supp_edit($sp_id, $mk_id, $sp_name,  $sp_tel);
