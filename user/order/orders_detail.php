<?php
include('../../_conf/conn.inc.php');

// Get values from query strings
$od_id=$_GET['od_id'];
$cust_id=$_GET['cust_id'];
$od_date=$_GET['od_date'];
$od_sday=$_GET['od_sday'];
$od_note=$_GET['od_note'];

// แสดงชื่อลูกค้า
$sql = "select * From customer where cust_id=$cust_id";
$result = mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$cust_name= $row['cust_name'];

?>
<!-- เพิ่มรายการสินค้า -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order_page</title>
    <!--<link rel="stylesheet" href="../_asset/css/style.css">-->
</head>
<body>
    <h1>ใบส่งสินค้า</h1>
 
    <div class="order_page">
    <div class="">
    <form>
        <label for="od_id">order_id</label>
        <input type="text" id="od_id" name="od_id" value="<?=$od_id?>">
         <label for="cust_id">รหัสลูกค้า:</label>
        <input type="text" id="cust_id" name="cust_id" value="<?=$cust_id?>">
        <label for="cust_name">ชื่อลูกค้า:</label>
        <input type="text" id="cust_name" name="cust_name" value="<?=$cust_name?>"><br><br>
        <!-- <label for="od_id">เลขที่บิล:</label>
        <input type="text" id="order_id" name="order_id"> -->
        <label for="od_sday">วันที่ส่งสินค้า:</label>
        <input type="date" id="order_date" name="order_date" value="<?=$od_date?>">
        <label for="od_note">หมายเหตุ:</label>
        <input type="text" id="od_note" name="od_note" value="<?=$od_note?>">
    </form >    

<br><br><br>
 <div>
    <form action="orders_detail_save.php" method="POST">
        <label for="">สินค้า</label>


         <select name="prod_id">
            <?php
            // add product in listbox

            $sql = "SELECT * FROM product ORDER BY prod_id";
            $result= mysqli_query($conn,$sql);
            
            while($row=mysqli_fetch_assoc($result)){
                echo '<option value="'. $row['prod_id'].'">'. $row['prod_name'].' ('.$row['prod_unit'] .') '.$row['prod_price'].'บาท</option>';
            }
            ?>
        </select>

        <label for="">จำนวน</label>
        <input type="number" min="1" max="10" name="ord_quantity">

        <input type="hidden" name="od_id" value="<?=$od_id?>">
        <input type="hidden" name="cust_id" value="<?=$cust_id?>">
        <input type="hidden" name="od_date" value="<?=$od_date?>">
        <input type="hidden" name="od_note" value="<?=$od_note?>">

        
        <input type="submit" value="เพิ่มรายการสินค้า">
    </form>
    <br><br><br>
        <table border="1" width="85%">
            <tr>
                <th>No.</th>
                <th>รหัสสินค้า</th>
                <th>ชื่อสินค้า</th>
                <th>หน่วยนับ</th>
                <th>จำนวน</th>
                <th>ราคาต่อหน่วย</th>
                <th>จำนวนเงิน</th>
            </tr>
            <?php 
//             ord_id
// รหัสรายละเอียดใบส่งสินค้า	prod_id
// รหัสสินค้า	ord_quantity
// จำนวนสินค้า	ord_price
// ราคาสินค้า	ord_type
// ประเภทสินค้า	od_id
// รหัสใบส่งสินค้า	

            // Show orders list
            $sql = "select 
                        orders_detail.od_id, orders_detail.prod_id, orders_detail.ord_quantity, product.prod_name,product.prod_unit, orders_detail.ord_price  
                    from 
                        orders_detail 
                    inner JOIN 
                        product 
                    on 
                        orders_detail.prod_id = product.prod_id 
                    where 
                        orders_detail.od_id = $od_id";
                        
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)>0){
                $i=1;
                while($row=mysqli_fetch_assoc($result)){
                    echo '<tr>';
                    echo '<td>'.$i.'</td>';
                    echo '<td>'.$row['prod_id'].'</td>';
                    echo '<td>'.$row['prod_name'].'</td>';
                    echo '<td>'.$row['prod_unit'].'</td>';
                    echo '<td>'.$row['ord_quantity'].'</td>';
                    echo '<td>'.$row['ord_price'].'</td>';
                    echo '<td>'.$row['ord_price']*$row['ord_quantity'].'</td>';
                    
                    echo '</tr>';
                    $i++;
                }
        }else{
            echo '<tr><td colspan="7">ไม่พบข้อมูล</td></tr>';
        }
            ?>
            
        </table>
        </div>
        <br><br><br>
        <a href="index.php" class="button">ใบส่งสินค้าส่งสินค้าสำเร็จ</a>
  <!--<input type="submit" value="บันทึกข้อมูล">-->
    </div>
</div>

<script>
  // เมื่อมีการเลือกวันที่ในฟอร์ม
  document.getElementById('order_date').addEventListener('change', function() {
    const inputDate = this.value; // รับค่าวันที่จากฟอร์ม (รูปแบบ: yyyy-mm-dd)
    const dateParts = inputDate.split('-'); // แยกวันที่ออกเป็นส่วนย่อย (ปี, เดือน, วัน)
    const formattedDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`; // สร้างรูปแบบใหม่ dd/mm/yyyy
    console.log(formattedDate); // แสดงวันที่ที่ถูกจัดรูปแบบใหม่ในคอนโซล
  });
</script>
</body>
</html>