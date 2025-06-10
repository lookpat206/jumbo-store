<?php
session_start();
session_destroy();

if (isset($stmt)) {
    mysqli_stmt_close($stmt);
}

if (isset($conn)) {
    mysqli_close($conn);
}

// Redirect ไปหน้า login
header("Location: index.php");
exit();
