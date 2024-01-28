<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jumbo_store";

//Create connection

$conn = mysqli_connect($servername,$username,$password,$dbname);

mysqli_set_charset($conn,"utf8");
// Check connection

//$sql = "CREATE DATABASE jumbo_store";

if (!$conn) {

    die("Connection failed: " . mysqli_connect_error());
}

//exit( "connected");

//mysqli_close($conn);

?>
