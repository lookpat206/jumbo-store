<?php
include ('_fn.php');

$dp_id = $_GET['dp_id'];
$c_id = $_GET['c_id'];

// echo $c_id;
// exit();


depart_delete($dp_id,$c_id);
?>