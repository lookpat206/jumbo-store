<?php

session_start();


include('_fn.php'); // ต้องมี stock_in()

header('Content-Type: application/json');


if (!isset($_SESSION['u_id'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Session หมดอายุ"
    ]);
    exit;
}

$u_id = intval($_SESSION['u_id']);

$data = json_decode(file_get_contents("php://input"), true);

$plan_id = intval($data['plan_id'] ?? 0);
$mk_id = intval($data['mk_id'] ?? 0);
$sp_id = intval($data['sp_id'] ?? 0);
$pd_id = intval($data['pd_id'] ?? 0);
$pu_id = intval($data['pu_id'] ?? 0);

$qty   = floatval($data['qty'] ?? 0);
$price = floatval($data['price'] ?? 0);

if ($mk_id <= 0 || $sp_id <= 0 || $pd_id <= 0 || $qty <= 0 || $price <= 0) {

    echo json_encode([
        "status" => "error",
        "message" => "ข้อมูลไม่ครบ"
    ]);
    exit;
}

$total = $qty * $price;

mysqli_begin_transaction($conn);

try {

    /* 1 update sp_list */

    $sql = "
    UPDATE sp_list pl
    JOIN mk_sup sup ON pl.sp_id = sup.sp_id
    SET
       
        pl.shop_price = ?,
        pl.syn_stock = 1,
        pl.sp_status = 'ซื้อสำเร็จ',
        pl.update_at = NOW()
    WHERE
        sup.mk_id = ?
        AND pl.sp_id = ?
        AND pl.pd_id = ?
        AND pl.u_id = ?
        AND pl.syn_stock = 0
    ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "diiii",

        $price,
        $mk_id,
        $sp_id,
        $pd_id,
        $u_id
    );

    mysqli_stmt_execute($stmt);


    /* 2 check purchase_header */

    $sql = "
    SELECT ph_id
    FROM purchase_header
    WHERE
    plan_id = ?
    AND mk_id = ?
    AND sp_id = ?
    AND u_id = ?
    AND DATE(ph_date) = CURDATE()
    LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iiii",
        $plan_id,
        $mk_id,
        $sp_id,
        $u_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        $ph_id = $row['ph_id'];
    } else {

        /* create purchase_header */

        $ph_code = "PH" . date("YmdHis") . rand(100, 999);
        $sql = "
        INSERT INTO purchase_header
        (ph_code,plan_id,mk_id,sp_id,u_id,ph_date,ph_status,created_at)
        VALUES
        (?,?,?,?,?,CURDATE(),'ซื้อแล้ว',NOW())
        ";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "siiii",
            $ph_code,
            $plan_id,
            $mk_id,
            $sp_id,
            $u_id
        );

        mysqli_stmt_execute($stmt);

        $ph_id = mysqli_insert_id($conn);
    }


    /* 3 check duplicate purchase_detail */

    $sql = "
    SELECT phdt_id
    FROM purch_detail
    WHERE ph_id = ? AND pd_id = ?
    LIMIT 1
    ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ii", $ph_id, $pd_id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$row = mysqli_fetch_assoc($result)) {

        /* insert purch_detail */

        $sql = "
        INSERT INTO purch_detail
        (ph_id,pd_id,pu_id,phdt_qty,phdt_price,phdt_total)
        VALUES
        (?,?,?,?,?,?)
        ";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "iiiddd",
            $ph_id,
            $pd_id,
            $pu_id,
            $qty,
            $price,
            $total
        );

        mysqli_stmt_execute($stmt);
    }


    /* 4 stock in */

    stock_in(
        $pd_id,
        $pu_id,
        $qty,
        $ph_id,
        date("Y-m-d H:i:s")
    );


    mysqli_commit($conn);

    echo json_encode([
        "status" => "success"
    ]);
} catch (Exception $e) {

    mysqli_rollback($conn);

    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
