<?php

//ใช้ดึงข้อมูลจาก DB
//connected  database
include('../_conf/conn.inc.php');


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
        header("Location:orders-check.php?od_id=$od_id");
    } else {
        echo "สร้างใบสั่งซื่อไม่สำเร็จ : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }
}

//ดึงข้อมูล orders
function fetch_orders()
{
    global $conn; //ประกาศตัวแปร conn

    //ดึงข้อมูล
    $sql = "SELECT *
            FROM orders ";

    $stmt = mysqli_prepare($conn, $sql);
    // ผูกพารามิเตอร์
    mysqli_stmt_execute($stmt);
    //เงื่อนไขการทำงาน
    $result = mysqli_stmt_get_result($stmt);
    //ส่งค่ากลับ
    return $result;
}

//ดึงข้อมูลรายระเอียด จาก od_id

function fetch_orders_by_id($od_id)
{
    global $conn;

    $sql = " SELECT  o.od_id, c.c_name ,o.od_day ,o.dv_day ,o.dv_time ,o.od_note ,c.c_id
            FROM orders AS o
            INNER JOIN cust AS c ON o.c_id = c.c_id
            WHERE o.od_id = ? ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 'i', $od_id);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);


    return $result;
}

//เพิ่มข้อมูล แผนก/ครัว

function update_orders($od_id, $od_note)
{
    global $conn;

    $sql = "UPDATE orders 
               SET 
                od_note = ?
                where 
                od_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    //ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "si", $od_note, $od_id);

    // ดำเนินการคำสั่ง
    if (mysqli_stmt_execute($stmt)) {
        //echo "บันทึกการแก้ไขเรียบร้อย";
        header("Location:od_detail.php?od_id=$od_id");
    } else {
        echo "Error : " . mysqli_stmt_error($stmt) . "<br>" . $sql;
    }

    // ปิดคำสั่ง
    //mysqli_stmt_close($stmt);
}
