<?php

include('_fn.php');

$mk_id = $_POST['mk_id'];
$sp_id = $_POST['sp_id'];
$pd_id = $_POST['pd_id'];
$u_id = $_POST['u_id'];

//exit($mk_id . $sp_id . $pd_id . $u_id);

plan_add_save($mk_id, $sp_id, $pd_id, $u_id);
