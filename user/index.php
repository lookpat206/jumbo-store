<?php 
session_start();

// if($_SESSION['u_status'] <> "Admin"){
//     header("Location:../login/logout.php");
// }

if(isset($_SESSION['u_name'])){
    $u_name = $_SESSION['u_name'];
}else {
    $u_name = "";
}

echo "<h1>Administrator</h1>";
//echo "Hello! " . $u_name;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="../_asset/css/style.css">

</head>
<body>
    <div class="admin-page">
        <div class="form">
            <a href="#" class="button">จัดการข้อมูล</a> <br>
            <a href="../a1/order/index.php" class="button">ใบส่งสินค้า</a> <br>
            <a href="#" class="button">แยกแหล่งซื้อสินค้า</a> <br>
            <a href="#" class="button">สินค้าคงเหลือ</a> <br>
            <a href="#" class="button">รายงานการซื้อ</a>

        </div>
</div>
</body>
</html>
<br><br>
<a href="../login/logout.php">Logout</a>