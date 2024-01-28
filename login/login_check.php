<?php
session_start();
include('../_conf/conn.inc.php');

//echo "hello!!";

$name = mysqli_real_escape_string($conn,$_POST['name']);
$pass = mysqli_real_escape_string($conn,$_POST['pass']);

//echo $name . '' .$pass;

$sql= "SELECT u_user, u_pass, u_status from js_user";

$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

$u_user = $row['u_user'];
$u_pass = $row['u_pass'];
$u_status = $row['u_status'];

//echo $u_name . '' .$u_pass;

if ($name == $u_user && $pass == $u_pass){
    echo "ผ่าน";
    if($u_status=="ผู้ดูแลระบบ"){
        $_SESSION['u_status'] = $u_status;
        $_SESSION['u_user'] = $u_user;

        header("Location: ../a1/");
        exit(0);
    }

    //header('Location:login.php');
} elseif ($name != $u_user) {
    echo "ไม่ผ่าน";
    $_SESSION['msg_err'] = "ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง";
    header('Location:index.php');
    exit(0);
} elseif ($pass != $u_pass){
    echo "ไม่ผ่าน";
    $_SESSION['msg_err'] = "ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง";
    header('Location:index.php');
    exit(0);
} 


//exit($u_pwd);


mysqli_close($conn);

?>
