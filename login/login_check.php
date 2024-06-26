<?php
session_start();
include('../_conf/conn.inc.php');

// Get username and password from POST request
$name = mysqli_real_escape_string($conn, $_POST['name']);
$pass = mysqli_real_escape_string($conn, $_POST['pass']);

// SQL query to check username and password
$sql = "SELECT u_user, u_pass, u_status FROM js_user WHERE u_user = '$name' AND u_pass = '$pass'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Fetch user data
    $row = mysqli_fetch_assoc($result);
    $u_user = $row['u_user'];
    $u_pass = $row['u_pass'];
    $u_status = $row['u_status'];

    // Start session and set session variables
    $_SESSION['u_user'] = $u_user;
    $_SESSION['u_status'] = $u_status;

    // Redirect based on user status
    if ($u_status == "ผู้ดูแลระบบ") {
        header("Location: ../admin/index.php");
    } elseif ($u_status == "พนักงาน") {
        header("Location: ../admin/index.php");
    } elseif ($u_status == "ลูกค้า") {
        header("Location: ../user/index.php");
    } else {
        $_SESSION['msg_err'] = "สถานะผู้ใช้ไม่ถูกต้อง";
        header('Location: index.php');
    }
    exit();
} else {
    // If username or password is incorrect
    $_SESSION['msg_err'] = "ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง";
    header('Location: index.php');
    exit();
}

mysqli_close($conn);
