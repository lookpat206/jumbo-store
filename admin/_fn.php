<?php

//ใช้ดึงข้อมูลจาก DB
//connected  database
include ('../_conf/conn.inc.php');

//====TB-js_user ================================================================
//ดึงข้อมูล user จาก js_user
function fetch_user(){
    global $conn;
    
    $sql = "SELECT 
                * 
            FROM 
                js_user";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);

    // ปิดคำสั่ง
    //mysqli_stmt_close($stmt);
    
    //exit($sql);

    
    //exit($result);
    return $result;
}


//===================================================================
//ดึงข้อมูล id ของ user
function fetch_user_by_uid($u_id){
    global $conn;
    
   $sql = "SELECT * 
            FROM js_user 
            WHERE u_id = ?";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $u_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

   // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);
    
    
    return $result;
}



//=====================================================================
//แก้ไขข้อมูล user
function user_edit($u_id,$u_name)
{
   global $conn;

   $sql = "UPDATE js_user 
               SET 
                u_name = ?
                where 
                u_id = ?";
    $stmt = mysqli_prepare($conn,$sql);

    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt,"si",$u_name,$u_id);
   
   // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        //echo "บันทึกการแก้ไขเรียบร้อย";
        header("Location:user.php");
    } else {
        echo "Error : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }

    // ปิดคำสั่ง
    //mysqli_stmt_close($stmt);

}



//=====================================================================
//บันทึกข้อมูล user จากการเพิ่มข้อมูล
function user_add_save($username,$u_name,$u_status){
    global $conn;

    // Using prepared statements to prevent SQL injection
    $sql = "INSERT INTO 
                js_user(u_user, u_name, u_pass, u_status) 
            VALUES (?, ?, '1234', ?)";

    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sss", $username, $u_name, $u_status);
    
    // Execute the statement
    if(mysqli_stmt_execute($stmt)){
        //echo "บันทึกข้อมูลผู้ใช้";
         header("Location:user.php");
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ: " . mysqli_stmt_error($stmt);
    }

//     // Close the statement
//     mysqli_stmt_close($stmt);

}


//========================================================================
//ลบข้อมูล user จาก datadase
function user_delete($u_id)
{
   global $conn;

   $sql = "DELETE FROM 
                     js_user 
                  WHERE 
                     u_id = ?";
    $stmt = mysqli_prepare($conn,$sql);

   // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $u_id);

    // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        //echo "ต้องการลบข้อมูลผู้ใช้งาน";
        header("Location:user.php");
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล" . mysqli_stmt_error($stmt) . $sql;
    }

}


//+++++TB-cust ++++++++++++++++++++++++++++++++++++++++++++++++
//ดึงข้อมูล 
function fetch_cust(){
    global $conn;
    
    $sql = "SELECT 
                * 
            FROM 
                cust";
    //exit($sql);

     // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);
    
    return $result;
}




//+++++++++++++++++++++++++++++++++++++++++++++++
//บันทึกข้อมูล cust จากการเพิ่มข้อมูล

function cust_add_save($c_name,$c_add,$c_tel,$c_abb){
    global $conn;

    $sql = "INSERT INTO cust(c_name, c_add, c_tel, c_abb)
                    VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "ssss", $c_name, $c_add, $c_tel, $c_abb);

    //เงื่อนไขการทำงาน

    if(mysqli_stmt_execute($stmt)) {
        header("Location:cust.php");
    }else{
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
   }

}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//ลบข้อมูลลูกค้า
function cust_delete($c_id){
    global $conn;

    $sql ="DELETE FROM
                    cust
                WHERE
                    c_id = (?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $c_id);

    if(mysqli_stmt_execute($stmt)) {
        header("Location:cust.php");
    }else{
      echo "ลบข้อมูลผู้ใช้ไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
   }                
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
////ดึงข้อมูล id ของ cust
function fetch_cust_by_cid($c_id){
    global $conn;
    
    $sql = "SELECT 
                * 
            FROM 
                cust 
            WHERE 
                c_id = (?)";

    $stmt = mysqli_prepare($conn, $sql);

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $c_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);

    
    return $result;
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//แก้ไขข้อมูล user
function cust_edit($c_id,$c_name,$c_add,$c_tel,$c_abb)
{
   global $conn;

   $sql = "UPDATE cust 
               SET 
                c_name = ?,
                c_add = ?,
                c_tel = ?,
                c_abb = ?'
                where 
                c_id = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ssssi", $c_name,$c_add,$c_tel,$c_abb,$c_id);
   
   if(mysqli_stmt_execute($stmt)){
      //echo "บันทึกการแก้ไขเรียบร้อย";
      header("Location:cust.php");
   }else {
      echo "Error : " . mysqli_stmt_error($stmt) . "<br>" . $sql ;
   }

}


//****TB- product *********************************************************** */


//ดึงข้อมูลจาก table product
function  fetch_prod(){
    global $conn;

    $sql=" SELECT * 
            FROM product";
    $stmt = mysqli_prepare($conn, $sql);

    
    mysqli_stmt_execute($stmt);

//รับค่าตัวแปร
    $result = mysqli_stmt_get_result($stmt);
    

    return $result;
}

//***************************************** */
//บันทึกข้อมูล product 
function prod_add_save($prod_n,$prod_q,$prod_f,$prod_i){
    global $conn;

    $sql = "INSERT INTO product(prod_n,prod_q,prod_f,prod_i)
                    VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "ssss", $prod_n,$prod_q,$prod_f,$prod_i);

    //เงื่อนไขการทำงาน

    if(mysqli_stmt_execute($stmt)) {
        header("Location:prod.php");
    }else{
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
   }

}


