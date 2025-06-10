<?php
// ต้อง include conn ด้วย
include('../_conf/conn.inc.php');

function login_user($username, $password)
{
    global $conn;

    // ใช้ prepared statement ป้องกัน SQL Injection
    $sql = "SELECT u_id, u_user, u_pass, u_status FROM js_user WHERE u_user = ? AND u_pass = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // ถ้าเจอ user
        return [
            'u_id' => $row['u_id'],
            'u_user' => $row['u_user'],
            'u_status' => $row['u_status']
        ];
    } else {
        // ไม่เจอ user
        return false;
    }
}
?>


?>