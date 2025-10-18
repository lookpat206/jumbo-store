<?php
// แก้ไขชื่อสินค้า
include('_fn.php');

$pd_n = $_POST['pd_n'];
$pd_id = $_POST['pd_id'];

echo $pd_id . $pd_name;

prod_update($pd_n, $pd_id);
