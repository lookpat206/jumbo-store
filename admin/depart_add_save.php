<?php
include ('_fn.php');

$c_id = $_POST["c_id"];
$dp_name = $_POST["dp_name"];

depart_add_save($c_id, $dp_name);

?>