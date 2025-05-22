<?php

//ใช้ดึงข้อมูลจาก DB
//connected  database
include('../_conf/conn.inc.php');


// ฟังก์ชันสร้างใบสั่งซื้อ
function create_od($c_id, $od_day, $dv_day, $dv_time, $od_note, $status_id = 'กำลังดำเนินการ')
{
    global $conn;

    // คำสั่ง SQL เตรียมเพิ่มข้อมูลใบสั่งซื้อ
    $sql = "INSERT INTO orders (c_id, od_day, dv_day, dv_time, od_note, status_id) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // เตรียม statement
    $stmt = mysqli_prepare($conn, $sql);

    // ตรวจสอบว่า prepare ผ่านหรือไม่
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn)); // แจ้ง error แบบละเอียด
    }

    // ผูกค่าตัวแปรกับ parameter ใน SQL โดยใช้รูปแบบ: int, string, string, string, string, string
    mysqli_stmt_bind_param($stmt, "isssss", $c_id, $od_day, $dv_day, $dv_time, $od_note, $status_id);

    // พยายาม execute คำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        // ถ้า execute ผ่าน ให้ return id ที่เพิ่มล่าสุด
        return mysqli_insert_id($conn);
    } else {
        // ถ้า execute ไม่ผ่าน ให้แสดง error
        echo "Execute failed: " . mysqli_stmt_error($stmt);
        return false;
    }
}


// ฟังก์ชันเพิ่มรายละเอียดสินค้า
function add_po_detail($od_id, $pd_id, $pu_id, $qty, $price_s, $total)
{
    global $conn;

    $sql = "INSERT INTO orders_detail (od_id, pd_id, pu_id, qty, price_s, total) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        // แสดง error จาก mysqli_prepare
        echo "Prepare failed: " . mysqli_error($conn);
        return false;
    }

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "iiiddd", $od_id, $pd_id, $pu_id, $qty, $price_s, $total);

    // รันคำสั่งและคืนค่าผลลัพธ์
    $result = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt); // ปิด statement
    return $result;
}

// ดึงราคาขายจากตารางราคา
function get_price($pd_id, $pu_id, $c_id)
{
    global $conn;
    $sql = "SELECT pri_sell FROM pri_detail WHERE pd_id = ? AND pu_id = ? AND c_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        echo "Prepare failed: " . mysqli_error($conn);
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iii", $pd_id, $pu_id, $c_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $pri_sell);

    if (mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        return $pri_sell;
    } else {
        mysqli_stmt_close($stmt);
        return false;
    }
}


// ดึงข้อมูลลูกค้า
function get_cust()
{
    global $conn;
    return mysqli_query($conn, "SELECT * FROM cust");
}

// ดึงข้อมูลสินค้า
function get_prod()
{
    global $conn;
    return mysqli_query($conn, "SELECT * FROM product");
}

// ดึงข้อมูลหน่วยนับ
function get_units()
{
    global $conn;
    return mysqli_query($conn, "SELECT * FROM p_unit");
}


// ฟังก์ชันดึงรายการสินค้าใน po_detail พร้อมชื่อสินค้าและหน่วย
function get_orders_detail($od_id)
{
    global $conn;
    $sql = "SELECT pd.pd_n, pu.pu_name, d.qty, d.price_s, d.total
            FROM orders_detail AS d
            JOIN product AS pd ON d.pd_id = pd.pd_id
            JOIN p_unit AS pu ON d.pu_id = pu.pu_id
            WHERE d.od_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    // ตรวจสอบว่า prepare ผ่านหรือไม่
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn)); // แจ้ง error แบบละเอียด
    }
    mysqli_stmt_bind_param($stmt, "i", $od_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function get_orders()
{
    global $conn;
    $sql = "SELECT o.od_id, c.c_name ,o.od_day ,o.dv_day,c.c_id, o.status_id
            FROM orders AS o
            INNER JOIN cust AS c ON o.c_id = c.c_id";
    return mysqli_query($conn, $sql);
}

function confirm_od($od_id)
{
    global $conn;
    $sql = "UPDATE orders SET status_id = 'สั่งซื้อสำเร็จ' WHERE od_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    // ตรวจสอบว่า prepare ผ่านหรือไม่
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn)); // แจ้ง error แบบละเอียด
    }
    mysqli_stmt_bind_param($stmt, "i", $od_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function get_departments_by_customer($c_id)
{
    global $conn;
    $sql = "SELECT dp_id, dp_name FROM c_depart WHERE c_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) return false;

    mysqli_stmt_bind_param($stmt, "i", $c_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
