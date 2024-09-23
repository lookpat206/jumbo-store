<?php
include('_fn.php');
$pri_id = $_GET['pri_id'];
$c_id = $_GET['c_id'];


//exit($pri_id . $c_id);

price_delete($pri_id, $c_id);
