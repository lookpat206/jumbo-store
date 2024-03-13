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

echo "<h1>User</h1>";
//echo "Hello! " . $u_name;
?>

