<?php 
include('_fn.php');

$prod_id = $_POST['prod_id']; //productID
$pu_id = $_POST['pu_id']; //unit
$price = $_POST['price']; //pricrSell
$c_id = $_POST['c_id']; //cust

//exit($prod_id . '' . $pu_id . '' .$price . ''.$c_id);

price_add_save($prod_id,$pu_id,$price,$c_id);

?>