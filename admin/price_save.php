<?php
include('_fn.php');

$c_id = $_POST['c_id'];
$pd_id = $_POST['pd_id'];
$pu_id = $_POST['pu_id'];
$pri_sell = $_POST['pri_sell'];

//exit("c_id :" . $c_id . '' . "pd_id :" . $pd_id .  '' . "pu_id :" . $pu_id . '' . "pri :" . $pri_sell);

price_save($c_id, $pd_id, $pu_id, $pri_sell);
