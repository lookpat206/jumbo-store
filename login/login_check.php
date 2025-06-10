<?php
session_start();
include('../_conf/conn.inc.php');
include('auth_fn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $pass = $_POST['pass'] ?? '';

    $userData = login_user($name, $pass);

    if ($userData) {
        $_SESSION['u_id'] = $userData['u_id'];
        $_SESSION['u_user'] = $userData['u_user'];
        $_SESSION['u_status'] = $userData['u_status'];

        switch ($userData['u_status']) {
            case 'ผู้ดูแลระบบ':
                header("Location: ../admin/index.php");
                break;
            case 'พนักงาน':
                header("Location: ../user/index.php");
                break;
            case 'ลูกค้า':
                header("Location: ../user/index.php");
                break;
            default:
                $_SESSION['msg_err'] = "สถานะผู้ใช้ไม่ถูกต้อง";
                header("Location:index.php");
        }
        exit();
    } else {
        $_SESSION['msg_err'] = "ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง";
        header("Location: index.php");
        exit();
    }
}
