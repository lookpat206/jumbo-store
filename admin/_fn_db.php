<?php

//เก็บฟังชันที่ใช้แสดงข้อมูล dashboard
//ใช้ดึงข้อมูลจาก DB
//connected  database
include('../_conf/conn.inc.php');

//// SELECT COUNT(*) as totalMK FROM `market`;

function fetch_totalMK()
{
    global $conn;

    $sql = "SELECT 
                COUNT (*) as totalMK 
            FROM 
                market";

    // เตรียมคำสั่ง SQL
    $stmt = mysqli_prepare($conn, $sql);

    // ดำเนินการคำสั่ง
    mysqli_stmt_execute($stmt);

    // รับผลลัพธ์
    $result = mysqli_stmt_get_result($stmt);

    // ปิดคำสั่ง
    mysqli_stmt_close($stmt);

    //exit($sql);


    //exit($result);
    return $result;
}
function fetch_total_counts()
{
    global $conn;

    $sql = "SELECT 'mk' AS table_name, COUNT(*) AS total FROM market
        UNION ALL
        SELECT 'prod', COUNT(*) FROM product
        UNION ALL
        SELECT 'cust', COUNT(*) FROM cust
        UNION ALL
        SELECT 'user', COUNT(*) FROM js_user
        UNION ALL
        SELECT 'supp', COUNT(*) FROM mk_sup;
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['table_name']] = $row['total'];
    }

    return $data;
}
