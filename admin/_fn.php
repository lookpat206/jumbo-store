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
    //exit($sql);

    $result = mysqli_query($conn,$sql);
    //exit($result);
    return $result;
}

//===================================================================
//ดึงข้อมูล id ของ user
function fetch_user_by_uid($u_id){
    global $conn;
    
    $sql = "SELECT 
                * 
            FROM 
                js_user 
            WHERE 
                u_id = $u_id";
    //exit($sql);

    $result = mysqli_query($conn,$sql);
    return $result;
}

//=====================================================================
//แก้ไขข้อมูล user
function user_edit($u_id,$u_name)
{
   global $conn;

   $sql = "UPDATE js_user 
               SET 
                u_name = '$u_name'
                where 
                u_id = $u_id";
   
   if(mysqli_query($conn,$sql)){
      //echo "บันทึกการแก้ไขเรียบร้อย";
      header("Location:user.php");
   }else {
      echo "Error : " . mysqli_error($conn) . "<br>" . $sql ;
   }

}

//=====================================================================
//บันทึกข้อมูล user จากการเพิ่มข้อมูล
function user_add_save($username,$u_name,$u_status){
    global $conn;

    $sql = "INSERT INTO js_user(u_user, u_name, u_pass, u_status) 
                  VALUES
                  ('$username','$u_name','1234','$u_status')";
    
    if(mysqli_query($conn,$sql)){
      //echo "บันทึกข้อมูลผู้ใช้";
      header("Location:user.php");
   }else{
      echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ : " . $sql . "<br>" . mysqli_error($conn);
   }

}

//========================================================================
//ลบข้อมูล user จาก datadase
function user_delete($u_id)
{
   global $conn;

   $sql = "DELETE FROM 
                     js_user 
                  WHERE 
                     u_id = $u_id";
   // exit($sql);

   if(mysqli_query($conn,$sql)){
     // echo "ต้องการลบข้อมูลผู้ใช้งาน";
      header("Location:user.php");
   }else{
      echo "เกิดข้อผิดพลาดในการลบข้อมูล" . mysqli_error($conn) . $sql;
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

    $result = mysqli_query($conn,$sql);
    //exit($result);
    

    return $result;
}

//+++++++++++++++++++++++++++++++++++++++++++++++
//บันทึกข้อมูล cust จากการเพิ่มข้อมูล

function cust_add_save($c_name,$c_add,$c_tel,$c_abb){
    global $conn;

    $sql = "INSERT INTO cust(c_name, c_add, c_tel, c_abb)
                    VALUES ('$c_name','$c_add','$c_tel','$c_abb')";

    if(mysqli_query($conn,$sql)){
        header("Location:cust.php");
    }else{
      echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ : " . $sql . "<br>" . mysqli_error($conn);
   }

}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//ลบข้อมูลลูกค้า
function cust_delete($c_id){
    global $conn;

    $sql ="DELETE FROM
                    cust
                WHERE
                    c_id = $c_id";

    if(mysqli_query($conn,$sql)){
        header("Location:cust.php");
    }else{
      echo "ลบข้อมูลผู้ใช้ไม่สำเร็จ : " . $sql . "<br>" . mysqli_error($conn);
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
                c_id = $c_id";
    //exit($sql);

    $result = mysqli_query($conn,$sql);
    return $result;
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//แก้ไขข้อมูล user
function cust_edit($c_id,$c_name,$c_add,$c_tel,$c_abb)
{
   global $conn;

   $sql = "UPDATE cust 
               SET 
                c_name = '$c_name',
                c_add = '$c_add',
                c_tel = '$c_tel',
                c_abb = '$c_abb'
                where 
                c_id = $c_id";
   
   if(mysqli_query($conn,$sql)){
      //echo "บันทึกการแก้ไขเรียบร้อย";
      header("Location:cust.php");
   }else {
      echo "Error : " . mysqli_error($conn) . "<br>" . $sql ;
   }

}


//****TB- product *********************************************************** */


//ดึงข้อมูลจาก table product
function  fetch_prod(){
    global $conn;

    $sql=" SELECT * 
            FROM product";

            //exit($sql);

    $result = mysqli_query($conn,$sql);
    //exit($result);
    

    return $result;
}

