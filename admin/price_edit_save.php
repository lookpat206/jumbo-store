<?php
include('_fn.php');

$pri_id = $_POST['pri_id'];
$c_id = $_POST['c_id'];
$pd_id = $_POST['pd_id'];
$pu_id = $_POST['pu_id'];
$pri_sell = $_POST['pri_sell'];

//exit($pri_id .  $c_id . $pd_id . $pu_id . $pri_sell);

price_edit($pd_id, $pu_id, $pri_sell, $pri_id, $c_id);
