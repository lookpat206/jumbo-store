<?php
include("_fn.php");

$od_id = $_POST["od_id"];
$od_note = $_POST["od_note"];

update_orders($od_id, $od_note);
