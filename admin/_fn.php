<?php

//ใช้ดึงข้อมูลจาก DB
//connected  database
include('../_conf/conn.inc.php');

//====TB-js_user ================================================================
//ดึงข้อมูล user จาก js_user
function fetch_user()
{
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
function fetch_user_by_uid($u_id)
{
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
function user_edit($u_id, $u_name)
{
    global $conn;

    $sql = "UPDATE js_user 
               SET 
                u_name = ?
                where 
                u_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "si", $u_name, $u_id);

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
function user_add_save($username, $u_name, $u_status)
{
    global $conn;

    // Using prepared statements to prevent SQL injection
    $sql = "INSERT INTO 
                js_user(u_user, u_name, u_pass, u_status) 
            VALUES (?, ?, '1234', ?)";

    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sss", $username, $u_name, $u_status);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
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
    $stmt = mysqli_prepare($conn, $sql);

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
function fetch_cust()
{
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

function cust_add_save($c_name, $c_add, $c_tel, $c_abb)
{
    global $conn;

    $sql = "INSERT INTO cust(c_name, c_add, c_tel, c_abb)
                    VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "ssss", $c_name, $c_add, $c_tel, $c_abb);

    //เงื่อนไขการทำงาน

    if (mysqli_stmt_execute($stmt)) {
        header("Location:cust.php");
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//ลบข้อมูลลูกค้า
function cust_delete($c_id)
{
    global $conn;

    $sql = "DELETE FROM
                    cust
                WHERE
                    c_id = (?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $c_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location:cust.php");
    } else {
        echo "ลบข้อมูลผู้ใช้ไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
////ดึงข้อมูล id ของ cust
function fetch_cust_by_cid($c_id)
{
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
//แก้ไขข้อมูล cust
function cust_edit($c_id, $c_name, $c_add, $c_tel, $c_abb)
{
    global $conn;

    $sql = "UPDATE cust 
               SET 
                c_name = ?,
                c_add = ?,
                c_tel = ?,
                c_abb = ?
                where 
                c_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssssi", $c_name, $c_add, $c_tel, $c_abb, $c_id);

    if (mysqli_stmt_execute($stmt)) {
        //echo "บันทึกการแก้ไขเรียบร้อย";
        header("Location:cust.php");
    } else {
        echo "Error : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }
}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//tb-department  
// บันทึกข้อมูลแผนงและครัว

function depart_add_save($c_id, $dp_name)
{
    global $conn;

    $sql = " INSERT INTO  c_depart(c_id,dp_name)
                VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "is", $c_id, $dp_name);

    //เงื่อนไขการทำงาน

    if (mysqli_stmt_execute($stmt)) {
        header("Location:department.php?c_id=$c_id");
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++
//ดึงข้อมูลdepartment by ID

function fetch_depart_by_id($c_id)
{
    global $conn;

    $sql = " SELECT c.c_name,cd.dp_name,cd.dp_id,cd.c_id 
                FROM c_depart as cd 
                INNER JOIN cust as c ON cd.c_id = c.c_id 
                WHERE cd.c_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $c_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}

//+++++++++++++++++++++++++++++++++++++++++++

// ลบข้อมูล department
function depart_delete($dp_id, $c_id)
{
    global $conn;

    $sql = "DELETE FROM
                    c_depart
                WHERE
                    dp_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $dp_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location:department.php?c_id=$c_id");
    } else {
        echo "ลบข้อมูลผู้ใช้ไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }
}


//++++++++++++++++++++++++++++++++++++++++++
//ดึงข้อมูลdepartment 

function fetch_depart()
{
    global $conn;

    $sql = "SELECT *
            FROM c_depart ";

    //exit($sql);

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);

    return $result;
}



//****TB-product *********************************************************** */


//ดึงข้อมูลจาก table product
function  fetch_prod()
{
    global $conn;

    $sql = " SELECT * 
            FROM product";
    $stmt = mysqli_prepare($conn, $sql);


    mysqli_stmt_execute($stmt);

    //รับค่าตัวแปร
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}

//***************************************** */
//บันทึกข้อมูล product   แก้ไข
function prod_add_save($prod_n, $prod_q, $prod_f, $prod_i)
{
    global $conn;

    $sql = "INSERT INTO product(prod_n,prod_q,prod_f,prod_i)
                    VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "ssss", $prod_n, $prod_q, $prod_f, $prod_i);

    //เงื่อนไขการทำงาน

    if (mysqli_stmt_execute($stmt)) {
        header("Location:prod.php");
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }
}

//************************************************** */
//บันทึกข้อมูล ราคาสินค้า price



function price_save($c_id, $pd_id, $pu_id, $pri_sell)
{
    global $conn;

    $sql = "INSERT INTO pri_detail(c_id, pd_id, pu_id, pri_sell) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn);
        exit();
    }

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "iiid", $c_id, $pd_id, $pu_id, $pri_sell);

    // ดำเนินการคำสั่ง SQL
    if (mysqli_stmt_execute($stmt)) {
        header("Location:price_add.php?c_id=$c_id&pd_id=$pd_id");
        exit();
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}



//**************************************************************** */

// ลบข้อมูลจากตาราง

function price_delete($pri_id)
{
    global $conn;

    $sql = "UPDATE products 
            SET deleted_at = NOW()
             WHERE pri_id = ? ";

    $stmt = mysqli_prepare($conn, $sql);

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $pri_id);

    // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        //echo "ต้องการลบข้อมูลผู้ใช้งาน";
        header("Location:price.php");
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล" . mysqli_stmt_error($stmt) . $sql;
    }
}

//***************************************** */

// ดึงข้อมูลจากตาราง pri_detail



// *******************************************************************
// ดึงข้อมูล id จาก TB-product
function fetch_product_by_prodid($pd_id)
{
    global $conn;

    $sql = "SELECT * 
            FROM product 
            WHERE pd_id = ?";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $pd_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}

// *******************************************************************
// ดึงข้อมูลจาก TB-unit
function fetch_unit()
{
    global $conn;

    $sql = "SELECT * 
            FROM p_unit
            ORDER BY `pu_id` ASC";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);
    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}
// *******************************************************************
// ดึงข้อมูลจาก TB-p_type
function fetch_type()
{
    global $conn;

    $sql = "SELECT * 
            FROM p_type";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}

// *******************************************************
// ดึงข้อมูลจาก TB-pri_detail โดยใช้ pd_id

function fetch_pri_detail_dy_pdid($pd_id)
{
    global $conn;
    $sql = "SELECT p.pd_n,u.pu_name,prd.pri_sell,prd.c_id,prd.pd_id,prd.pri_id 
            FROM pri_detail as prd 
            INNER JOIN cust as c on prd.c_id=c.c_id
            INNER JOIN product as p on prd.pd_id = p.pd_id 
            INNER JOIN p_unit as u on prd.pu_id = u.pu_id 
            WHERE prd.pd_id = ? ";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $pd_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}






//###############################################################
// ดึงข้อมูล supplier

function fetch_supp()
{
    global $conn;
    $sql = "SELECT s.sp_id, s.sp_name, pt.pt_name, m.mk_name, s.sp_tel,pt.pt_id 
            FROM supplier AS s 
            INNER JOIN p_type as pt ON s.pt_id = pt.pt_id 
            INNER JOIN market as m ON s.mk_id = m.mk_id 
            ORDER BY pt.pt_id  DESC ";
    // แปลง $sql เป็น $stmt
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_execute($stmt);
    // แสดงผลข้อมูล
    $result = mysqli_stmt_get_result($stmt);

    return $result;
}

//###############################################################
//ดึงข้อมูล market
function fetch_mark()
{
    global $conn;
    $sql = "SELECT * 
            FROM market ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return $result;
}

//###############################################
//เพิ่มข้อมูลร้านค้า
function supp_add_save($sp_name, $pt_id, $mk_id, $sp_tel)
{
    global $conn;

    $sql = "INSERT INTO supplier(sp_name, pt_id, mk_id, sp_tel) 
            VALUES (?, ?, ?, ?)";
    // แปลง $sql เป็น $stmt            
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn);
        exit();
    }

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "siis", $sp_name, $pt_id, $mk_id, $sp_tel);

    // ดำเนินการคำสั่ง SQL
    if (mysqli_stmt_execute($stmt)) {
        header("Location:supplier.php");
        exit();
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

//######################################################################
// รับค่า id แล้วดึงข้อมูลจาก TB-supplier

function fetch_supp_by_spid($sp_id)
{
    global $conn;
    $sql = "SELECT *
            FROM supplier
            WHERE sp_id = ? ";

    $stmt = mysqli_prepare($conn, $sql);

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $sp_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}
