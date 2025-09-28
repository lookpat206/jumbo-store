<?php
session_start();
include('_fn.php');

if (isset($_POST['c_id']) && isset($_POST['pd_id'])) {
    $c_id = intval($_POST['c_id']);
    $pd_id = intval($_POST['pd_id']);

    $units = get_units_by_customer_and_product($c_id, $pd_id);

    header('Content-Type: application/json');
    echo json_encode($units);
}
