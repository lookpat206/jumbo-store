<?php 
session_start();
session_destroy();
// ปิดคำสั่ง
    mysqli_stmt_close($stmt);
echo "5555";
header("Location:index.php");
echo "6666";
exit(0);

?>