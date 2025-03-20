<?php
include('_fn.php');

$plan_id = $_POST['plan_id'];
$mk_id = $_POST['mk_id'];
$sp_id = $_POST['sp_id'];
$pd_id = $_POST['pd_id'];
$u_id = $_POST['u_id'];

//exit("plan_id: $plan_id, mk_id: $mk_id, sp_id: $sp_id, pd_id: $pd_id, u_id: $u_id");

plan_edit($plan_id, $mk_id, $sp_id, $pd_id, $u_id);
