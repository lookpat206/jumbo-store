<?php

include('_fn.php');
$u_id = $_POST['u_id'];
$u_name = $_POST['u_name'];
$u_status = $_POST['u_status'];

print_r($u_id . $u_name . $u_status);

user_edit($u_id, $u_name, $u_status);
