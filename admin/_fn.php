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
        header("Location:price_add.php?c_id=$c_id");
        exit();
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}



//**************************************************************** */

// ลบข้อมูลจากตาราง

function price_delete($pri_id, $c_id)
{
    global $conn;

    $sql = "DELETE FROM 
                    pri_detail
             WHERE
                    pri_id = ? ";

    $stmt = mysqli_prepare($conn, $sql);

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $pri_id);

    // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        //echo "ต้องการลบข้อมูลผู้ใช้งาน";
        header("Location:price_add.php?c_id=$c_id");
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล" . mysqli_stmt_error($stmt) . $sql;
    }
}

//***************************************** */

// ดึงข้อมูลจาก TB-pri_detail โดยใช้ c_id

function fetch_pri_detail_dy_pdid($c_id)
{
    global $conn;
    $sql = "SELECT p.pd_n,u.pu_name,prd.pri_sell,prd.c_id,prd.pd_id,prd.pri_id 
            FROM pri_detail as prd 
            INNER JOIN cust as c on prd.c_id=c.c_id
            INNER JOIN product as p on prd.pd_id = p.pd_id 
            INNER JOIN p_unit as u on prd.pu_id = u.pu_id 
            WHERE prd.c_id = ? ";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $c_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}

//***************************************** */
// ดึงข้อมูลจาก TB-pri_detail โดยใช้ pri_id

function   fetch_pri_detail_dy_priid($pri_id)
{
    global $conn;
    $sql = "SELECT p.pd_n,u.pu_name,prd.pri_sell,prd.c_id,prd.pd_id,prd.pri_id,prd.pu_id
            FROM pri_detail as prd 
            INNER JOIN cust as c on prd.c_id=c.c_id
            INNER JOIN product as p on prd.pd_id = p.pd_id 
            INNER JOIN p_unit as u on prd.pu_id = u.pu_id 
            WHERE prd.pri_id = ? ";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $pri_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}

//***************************************** */
// แก้ไขข้อมูล ราคาสินค้า TB-pri_detail

function price_edit($pd_id, $pu_id, $pri_sell, $pri_id, $c_id)
{
    global $conn;

    $sql = "UPDATE pri_detail 
               SET pd_id = ?,
                pu_id = ?,
                pri_sell = ?
                where 
                pri_id = ? 
                AND
                c_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iiiii", $pd_id, $pu_id, $pri_sell, $pri_id, $c_id);

    if (mysqli_stmt_execute($stmt)) {
        //echo "บันทึกการแก้ไขเรียบร้อย";
        header("Location:price.php?c_id=$c_id");
    } else {
        echo "Error : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }

    mysqli_stmt_close($stmt);
}



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





//###############################################################
// ดึงข้อมูล supplier

function fetch_supp()
{
    global $conn;
    $sql = "SELECT * 
            FROM mk_sup
            join p_type on mk_sup.pt_id = p_type.pt_id";
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

//###############################################################
// รับค่า id แล้วดึงข้อมูลจาก TB-market

function fetch_mark_by_mkid($mk_id)
{
    global $conn;
    $sql = "SELECT *
            FROM market
            WHERE mk_id = ? ";

    $stmt = mysqli_prepare($conn, $sql);

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $mk_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}

//###############################################################
//เพิ่มข้อมูล ตาราง market

function mark_add_save($mk_name)
{
    global $conn;

    $sql = "INSERT INTO market(mk_name) 
            VALUES (?)";
    // แปลง $sql เป็น $stmt            
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn);
        exit();
    }

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "s", $mk_name);

    // ดำเนินการคำสั่ง SQL
    if (mysqli_stmt_execute($stmt)) {
        header("Location:market.php");
        exit();
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}


//###############################################################
// แก้ไขข้อมูล ตาราง market

function mark_edit($mk_id, $mk_name)
{
    global $conn;

    $sql = "UPDATE market 
               SET 
                mk_name = ?
                where 
                mk_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "si", $mk_name, $mk_id);

    if (mysqli_stmt_execute($stmt)) {
        //echo "บันทึกการแก้ไขเรียบร้อย";
        header("Location:market.php");
    } else {
        echo "Error : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }

    mysqli_stmt_close($stmt);
}

//###############################################################   
// ลบข้อมูล ตาราง market

function mark_delete($mk_id)
{
    global $conn;

    $sql = "DELETE FROM 
                     market 
                  WHERE 
                     mk_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $mk_id);

    // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        //echo "ต้องการลบข้อมูลผู้ใช้งาน";
        header("Location:market.php");
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล" . mysqli_stmt_error($stmt) . $sql;
    }

    mysqli_stmt_close($stmt);
}


//###############################################
//เพิ่มข้อมูลร้านค้าจาก TB-supp
function supp_add_save($sp_name, $pt_id, $sp_tel)
{
    global $conn;

    $sql = "INSERT INTO mk_sup(sp_name, pt_id, sp_tel) 
            VALUES (?, ?, ?)";
    // แปลง $sql เป็น $stmt            
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn);
        exit();
    }

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "sis", $sp_name, $pt_id, $sp_tel);

    // ดำเนินการคำสั่ง SQL
    if (mysqli_stmt_execute($stmt)) {
        header("Location:supp.php?");
        exit();
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

//######################################################################
// รับค่า id แล้วดึงข้อมูลจาก TB-supp

function fetch_supp_by_spid($sp_id)
{
    global $conn;
    $sql = "SELECT *
            FROM mk_sup
            JOIN p_type ON mk_sup.pt_id = p_type.pt_id
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

//######################################################################
// แก้ไขข้อมูล ร้านค้า TB-supp

function supp_edit($sp_id, $sp_name, $pt_id, $sp_tel)
{
    global $conn;

    $sql = "UPDATE mk_sup 
               SET 
                sp_name = ?,
                pt_id = ?,
                sp_tel = ?
                where 
                sp_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "sisi", $sp_name, $pt_id, $sp_tel, $sp_id);

    if (mysqli_stmt_execute($stmt)) {
        //echo "บันทึกการแก้ไขเรียบร้อย";
        header("Location:supp.php");
    } else {
        echo "Error : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }

    mysqli_stmt_close($stmt);
}


//######################################################################
//ลบข้อมูล ร้านค้า TB-supp

function supp_delete($sp_id)
{
    global $conn;

    $sql = "DELETE FROM 
                     mk_sup 
                  WHERE 
                     sp_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $sp_id);

    // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        //echo "ต้องการลบข้อมูลผู้ใช้งาน";
        header("Location:supp.php");
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล" . mysqli_stmt_error($stmt) . $sql;
    }

    mysqli_stmt_close($stmt);
}


//*************************************************************** */
// ดึงข้อมูลจาก TB-plan
function fetch_plan()
{
    global $conn;

    $sql = "SELECT * 
            FROM plan
            JOIN market ON plan.mk_id = market.mk_id
            JOIN mk_sup ON plan.sp_id = mk_sup.sp_id
            JOIN product ON plan.pd_id = product.pd_id
            JOIN js_user ON plan.u_id = js_user.u_id
            ORDER BY plan_id DESC";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);

    return $result;
}

//*************************************************************** */
// ดึงข้อมูลจาก TB-plan โดยใช้ plan_id

function fetch_plan_by_planid($plan_id)
{
    global $conn;

    $sql = "SELECT  market.mk_name,mk_sup.sp_name,product.pd_n,js_user.u_name,
                    plan.plan_id,plan.mk_id,plan.sp_id,plan.pd_id,plan.u_id

            FROM plan 
             JOIN market ON plan.mk_id = market.mk_id
            JOIN mk_sup ON plan.sp_id = mk_sup.sp_id
            JOIN product ON plan.pd_id = product.pd_id
            JOIN js_user ON plan.u_id = js_user.u_id
            WHERE plan_id = ? ";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $plan_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);

    return $result;
}

//*************************************************************** */
// บันทึกข้อมูล แผนจากการเพิ่มข้อมูล

function plan_add_save($mk_id, $sp_id, $pd_id, $u_id)
{
    global $conn;

    $sql = "INSERT INTO plan(mk_id, sp_id, pd_id, u_id) 
            VALUES (?, ?, ?, ?)";
    // แปลง $sql เป็น $stmt            
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn);
        exit();
    }

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "iiii", $mk_id, $sp_id, $pd_id, $u_id);

    // ดำเนินการคำสั่ง SQL
    if (mysqli_stmt_execute($stmt)) {
        header("Location:plan.php");
        exit();
    } else {
        echo "เพิ่มข้อมูลผู้ใช้ไม่สำเร็จ: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}

//*************************************************************** */
// แก้ไขข้อมูล แผนจาก TB-plan

function plan_edit($plan_id, $mk_id, $sp_id, $pd_id, $u_id)
{
    global $conn;

    $sql = "UPDATE plan 
               SET 
                mk_id = ?,
                sp_id = ?,
                pd_id = ?,
                u_id = ?
                where 
                plan_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "iiiii", $mk_id, $sp_id, $pd_id, $u_id, $plan_id);

    // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        //echo "บันทึกการแก้ไขเรียบร้อย";
        header("Location:plan.php");
    } else {
        echo "Error : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }

    mysqli_stmt_close($stmt);
}


//******************************************************************* */
// ลบข้อมูล แผนจาก TB-plan

function plan_delete($plan_id)
{
    global $conn;

    $sql = "DELETE FROM 
                     plan 
                  WHERE 
                     plan_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "i", $plan_id);

    // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        //echo "ต้องการลบข้อมูลผู้ใช้งาน";
        header("Location:plan.php");
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล" . mysqli_stmt_error($stmt) . $sql;
    }

    mysqli_stmt_close($stmt);
}


// 333333333333333333333333333333333333333333333333333333333333333
//TB-orders
//บันทึกข้อมูล orders
function order_add_save($c_id, $od_day, $dv_day, $dv_time, $od_note)
{
    global $conn;

    $sql = "INSERT INTO orders(c_id,od_day,dv_day, dv_time,od_note)
                    VALUES (?, ?, ?, ?,?)";
    $stmt = mysqli_prepare($conn, $sql);

    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "issss", $c_id, $od_day, $dv_day, $dv_time, $od_note);

    //เงื่อนไขการทำงาน

    if (mysqli_stmt_execute($stmt)) {
        //รับค่า od_id
        $od_id = mysqli_insert_id($conn);
        header("Location:order-check.php?od_id=$od_id");
    } else {
        echo "สร้างใบสั่งซื่อไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }
}


//spspspspspspspspspspspspspspspsspspspspsps

//ดึงข้อมูล orders details
function save_shopping($dv_day_new)
{
    global $conn;

    $sql = "INSERT INTO sp_list (mk_id, sp_id, u_id, od_id, pd_id, quantity, pu_id, sp_price, sp_status)
            SELECT p.mk_id, p.sp_id, p.u_id, od.od_id, ord.pd_id, ord.qty, ord.pu_id,ord.price_s, 'กำลังซื้อสินค้า'
            FROM orders_detail AS ord
            JOIN orders AS od ON ord.od_id = od.od_id
            JOIN plan AS p ON ord.pd_id = p.pd_id
            WHERE od.dv_day = ?";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    // ผูกพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "s", $dv_day_new);

    // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        // ดูจำนวน row ที่ insert ได้จริง
        $rows_inserted = mysqli_stmt_affected_rows($stmt);

        // Redirect ไปหน้า order-check.php
        header("Location: shopping.php?success=1&rows=$rows_inserted");
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกรายการซื้อสินค้า: " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }

    // ปิด statement
    mysqli_stmt_close($stmt);
}

//spspspspsppspspsppspspsppspspsppspspsppspspspspsppspspspspsp

//ดึงข้อมูล shopping list
function get_sp_list()
{
    global $conn;

    $sql = "SELECT m.mk_name, 
                sup.sp_name, 
                u.u_name,
                pl.pd_id, 
                pro.pd_n,            
                SUM(pl.quantity) AS quantity, 
                pu.pu_name, 
                pl.sp_price,
                SUM(pl.quantity) * pl.sp_price AS total_price,
                pl.sp_status
                
            FROM sp_list AS pl
            JOIN market AS m ON pl.mk_id = m.mk_id
            JOIN mk_sup AS sup ON pl.sp_id = sup.sp_id
            JOIN js_user AS u ON pl.u_id = u.u_id
            JOIN product AS pro ON pl.pd_id = pro.pd_id
            JOIN p_unit AS pu ON pl.pu_id = pu.pu_id
            join orders AS od ON pl.od_id = od.od_id
            join cust AS c ON od.c_id = c.c_id
            GROUP BY pl.pd_id, pl.mk_id, pl.sp_id, pl.u_id, pl.pu_id, pl.sp_price, pl.sp_status
            ORDER BY pl.mk_id DESC";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Get result failed: " . mysqli_error($conn));
    }
    return $result; // คืนผลลัพธ์ไปให้หน้า main ใช้
}


//spspspspspspspspspspspspspspspsspspspspsps
//ดึงข้อมูล shopping list โดยใช้ pl_id
function fetch_sp_list_by_plid($pl_id)

{
    global $conn;

    $sql = "SELECT m.mk_name, 
                sup.sp_name, 
                u.u_name, 
                pro.pd_n,            
                pl.quantity, 
                pu.pu_name, 
                pl.sp_price, 
                pl.sp_status,
                pl.pl_id,
                pl.mk_id,
                pl.sp_id,
                pl.pd_id,
                pl.u_id
                
            FROM sp_list AS pl
            JOIN market AS m ON pl.mk_id = m.mk_id
            JOIN mk_sup AS sup ON pl.sp_id = sup.sp_id
            JOIN js_user AS u ON pl.u_id = u.u_id
            JOIN product AS pro ON pl.pd_id = pro.pd_id
            JOIN p_unit AS pu ON pl.pu_id = pu.pu_id
            
            WHERE pl.pl_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $pl_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        die("Query failed (fetch_sp_list_by_plid): " . mysqli_error($conn));
    }

    return $result; // คืนผลลัพธ์ไปให้หน้า main ใช้
}

//นับจำนวนรายการใน shopping list 

function count_failed_delivery()
{
    global $conn;

    $sql = "SELECT COUNT(*) AS total_failed 
            FROM sp_list 
            WHERE sp_status = 'จัดส่งไม่สำเร็จ'";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed (count_failed_delivery): " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    return $row['total_failed']; // คืนค่าเป็นจำนวน
}

//spspspspspspsppspspspspspspspspspspspspspspspspspsps
//แก้ไขข้อมูล shopping list


function sp_list_edit($pl_id, $mk_id, $sp_id, $u_id, $quantity, $sp_price, $sp_status)
{
    global $conn;

    $sql = "UPDATE sp_list 
               SET 
                mk_id = ?,
                sp_id = ?,
                u_id = ?,
                quantity = ?,
                sp_price = ?,
                sp_status = ?
                WHERE pl_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iiiiddi", $mk_id, $sp_id,  $u_id, $quantity,  $sp_price, $sp_status, $pl_id);

    if (mysqli_stmt_execute($stmt)) {
        //echo "บันทึกการแก้ไขเรียบร้อย";
        header("Location:shopping.php");
    } else {
        echo "Error : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }

    mysqli_stmt_close($stmt);
}

function get_status_text_and_class($status_code)
{
    switch ($status_code) {
        case 0:
            return ['สั่งซื้อสำเร็จ', 'status-orange'];
        case 1:
            return ['กำลังดำเนินการ', 'status-yellow'];
        case 2:
            return ['การจัดส่งสำเร็จ', 'status-green'];
        case 3:
            return ['จัดส่งไม่สำเร็จ', 'status-red'];
        default:
            return ['ไม่ทราบสถานะ', 'status-default'];
    }
}
