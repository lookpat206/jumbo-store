<?php
include('_fn.php');
include('../admin/_fn.php');

$sp_id = $_POST['sp_id'];
$od_id = $_POST['od_id'];
$stock_id = $_POST['stock_id'];
$qty = $_POST['qty'];

update_delivery($sp_id, $od_id, $stock_id, $qty);

echo "success";
