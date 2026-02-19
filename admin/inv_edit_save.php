<?php

include('_fn.php');
$odt_id = intval($_POST['odt_id']);
$qty = floatval($_POST['qty']);

$update_result = update_order_quantity($odt_id, $qty);
