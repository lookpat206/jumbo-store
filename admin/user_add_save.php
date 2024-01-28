<?php 
include('_fn.php');

$username = $_POST['username'];
$u_name = $_POST['u_name'];
$u_status = $_POST['u_status'];

// exit($username . ' ' . $u_name.' '.$u_status);

user_add_save($username,$u_name,$u_status);

?>