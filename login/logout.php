<?php 
session_start();
session_destroy();
echo "5555";
header("Location:index.php");
echo "6666";
exit(0);

?>