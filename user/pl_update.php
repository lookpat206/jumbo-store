<?php
require_once '_fu.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pd_id = intval($_POST['pd_id']);
    $shop_id = intval($_POST['shop_id']);
    $quantity = floatval($_POST['quantity']);
    $unit_price = floatval($_POST['unit_price']);
    $unit_id = intval($_POST['unit_id']);

    $success = complete_purchase($pd_id, $sp_id, $quantity, $unit_price, $unit_id);

    if ($success) {
        echo "success";
    } else {
        echo "error";
    }
}
