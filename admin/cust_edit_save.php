<?php 

include('_fn.php');
$c_id = $_POST['c_id'];
$c_name = $_POST['c_name'];
$c_add = $_POST['c_add'];
$c_tel = $_POST['c_tel'];
$c_abb = $_POST['c_abb'];

cust_edit($c_id, $c_name, $c_add, $c_tel, $c_abb);

?>