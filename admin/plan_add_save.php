<?php

include('_fn.php');


$sp_id = $_POST['sp_id'];
$pd_id = $_POST['pd_id'];
$u_id = $_POST['u_id'];

//exit($mk_id . $sp_id . $pd_id . $u_id);

plan_add_save($sp_id, $pd_id, $u_id);
