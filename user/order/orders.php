<?php
//สร้างใบสั่งซื้อโดยเพิ่มชื่อลูกค้า/วันที่สั่ง/ส่งและหมายเหตุ

include('../../_conf/conn.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>รายชื่อลูกค้า</h1>

    <form action="orders_save.php" method="GET">
         <label for="">ชื่อลูกค้า:</label>
        <select name="cust_id">
           
            <?php
            $sql = "SELECT * FROM cust ORDER BY cust_name";
            $result= mysqli_query($conn,$sql);
        
            while($row=mysqli_fetch_assoc($result)){
               
                echo '<option value="'. $row['cust_id'].'">'. $row['cust_name'].'</option>';
            }
            ?>
            
        </select>
        <br><br>
        <label for="">วันที่สั่ง: </label>
        <input type="date" name="od_date" id=""><br><br>
        <label for="">วันที่จัดส่ง:</label>
        <input type="date" name="od_del_date" id=""><br><br>
        <label for="">แผนก/ครัว</label>
        <input type="text" name="od_note" id=""><br><br>
        <label for="">จำนวนรายการสินค้า</label>
        <input type="text" name="num" id=""><br><br>


        <input type="submit" value="สร้างใบสั่งซื้อสินค้า">
    </form>
    


    
</body>
</html>