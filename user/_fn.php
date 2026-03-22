<?php
// user/_fn.php
//ใช้ดึงข้อมูลจาก DB
//connected  database
include('../_conf/conn.inc.php');


// ฟังก์ชันสร้างใบสั่งซื้อ
function create_od($c_id, $od_day, $dv_day, $dv_time, $dp_id, $od_status = 'ร่างใบสั่งซื้อ')
{
    global $conn;

    // คำสั่ง SQL เตรียมเพิ่มข้อมูลใบสั่งซื้อ
    $sql = "INSERT INTO orders (c_id, od_day, dv_day, dv_time, dp_id, od_status) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // เตรียม statement
    $stmt = mysqli_prepare($conn, $sql);

    // ตรวจสอบว่า prepare ผ่านหรือไม่
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn)); // แจ้ง error แบบละเอียด
    }

    // ผูกค่าตัวแปรกับ parameter ใน SQL โดยใช้รูปแบบ: int, string, string, string, string, string
    mysqli_stmt_bind_param($stmt, "isssis", $c_id, $od_day, $dv_day, $dv_time, $dp_id, $od_status);

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


// ฟังก์ชันเพิ่มรายการสินค้า
function add_po_detail($od_id, $pd_id, $pu_id, $qty, $price_s, $total, $od_detail)
{
    global $conn;

    $sql = "INSERT INTO orders_detail (od_id, pd_id, pu_id, qty, price_s, total,od_detail) VALUES (?, ?, ?, ?, ?, ?,?)";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        // แสดง error จาก mysqli_prepare
        echo "Prepare failed: " . mysqli_error($conn);
        return false;
    }

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "iiiddds", $od_id, $pd_id, $pu_id, $qty, $price_s, $total, $od_detail);

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

// ดึงข้อมูลสินค้าจากตาราง pri_detail โดยกรองด้วย c_id
function get_products_by_customer($c_id)
{
    global $conn;
    $sql = "SELECT DISTINCT pd.pd_id, pd.pd_n
            FROM pri_detail AS pri
            JOIN product AS pd ON pri.pd_id = pd.pd_id
            WHERE pri.c_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $c_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    return $products;
}

// ดึงข้อมูลหน่วยนับจากตาราง pri_detail โดยกรองด้วย c_id และ pd_id
function get_units_by_customer_and_product($c_id, $pd_id)
{
    global $conn;
    $sql = "SELECT pu.pu_id, pu.pu_name
            FROM pri_detail AS pri
            JOIN p_unit AS pu ON pri.pu_id = pu.pu_id
            WHERE pri.c_id = ? AND pri.pd_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $c_id, $pd_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $units = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $units[] = $row;
    }
    return $units;
}

// ฟังก์ชันดึงรายการสินค้าใน po_detail พร้อมชื่อสินค้าและหน่วย
function get_orders_detail($od_id)
{
    global $conn;
    $sql = "SELECT pd.pd_n, pu.pu_name, d.qty, d.price_s, d.total,d.ord_id,d.pd_id,d.pu_id
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

// ฟังก์ชันดึงข้อมูลใบสั่งซื้อพร้อมรายการสินค้า
function get_order_by_id($od_id)
{
    global $conn;
    $sql = "SELECT o.od_id, c.c_name ,o.od_day ,o.dv_day,c.c_id, o.dv_time, o.od_note,c.c_add,c.c_tel
            FROM orders AS o
            INNER JOIN cust AS c ON o.c_id = c.c_id
             WHERE od_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    // ตรวจสอบว่า prepare ผ่านหรือไม่
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn)); // แจ้ง error แบบละเอียด
    }
    mysqli_stmt_bind_param($stmt, "i", $od_id);
    mysqli_stmt_execute($stmt);
    // ดึงผลลัพธ์จาก statement
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result); // ✅ คืนเป็น array
}


// ฟังก์ชันดึงข้อมูลใบสั่งซื้อทั้งหมด
function get_orders()
{
    global $conn;
    $sql = "SELECT o.od_id, c.c_name ,o.od_day ,o.dv_day,c.c_id, o.od_status
            FROM orders AS o
            INNER JOIN cust AS c ON o.c_id = c.c_id";
    return mysqli_query($conn, $sql);
}

function confirm_od($od_id)
{
    global $conn;
    $sql = "UPDATE orders SET od_status = 'รอดำเนินการจัดซื้อ' WHERE od_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    // ตรวจสอบว่า prepare ผ่านหรือไม่
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn)); // แจ้ง error แบบละเอียด
    }
    mysqli_stmt_bind_param($stmt, "i", $od_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}




// ฟังก์ชันดึงข้อมูลแผนก/ครัวตามรหัสลูกค้า
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


// ฟังก์ชันลบรายการใน orders_detail ตามรหัส odr_id
function delete_order_detail($ord_id)
{
    global $conn;
    $sql = "DELETE FROM orders_detail WHERE ord_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $ord_id);

    return mysqli_stmt_execute($stmt);
}

// ฟังก์ชันลบใบสั่งซื้อ
function delete_po($od_id)
{
    global $conn;

    $sql = "DELETE FROM orders WHERE od_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn)); // แจ้ง error แบบละเอียด
    }
    mysqli_stmt_bind_param($stmt, "i", $od_id);
    $result = mysqli_stmt_execute($stmt);
    return $result;
}


function fetch_market_byuid($u_id)
{
    global $conn;

    $sql = "SELECT 
    js.u_id, 
    js.u_name, 
    sup.mk_id, 
    m.mk_name
FROM sp_list AS sp
JOIN js_user AS js ON sp.u_id = js.u_id
JOIN mk_sup AS sup ON sp.sp_id = sup.sp_id
JOIN market AS m ON sup.mk_id = m.mk_id
WHERE js.u_id = ?
GROUP BY js.u_id, js.u_name, sup.mk_id, m.mk_name";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("SQL Prepare Failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $u_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}




// ดึงรายละเอียดสินค้าในแต่ละตลาดของผู้ใช้
function get_market_details($mk_id, $u_id)
{
    global $conn;

    $sql = "SELECT MAX(pl.syn_stock) AS syn_stock,
                pl.sp_status,
                pl.pd_id,
                pl.plan_id, 
                pl.sp_id, 
                sup.sp_name, 
                p.pd_n, 
                SUM(pl.shop_qty) AS quantity, 
                pu.pu_id,
                pu.pu_name, 
                ROUND(AVG(pl.shop_price), 2) AS sp_price,
                ROUND(SUM(pl.shop_qty) * AVG(pl.shop_price), 2) AS total_price
                
            FROM sp_list AS pl
            INNER JOIN product AS p ON pl.pd_id = p.pd_id
            INNER JOIN mk_sup AS sup ON pl.sp_id = sup.sp_id
            JOIN p_unit AS pu ON pl.pu_id = pu.pu_id
            WHERE sup.mk_id = ? AND pl.u_id = ? AND syn_stock = 0 AND is_closed = 0
            GROUP BY pl.pd_id, pl.sp_id, sup.sp_name, p.pd_n, pu.pu_id, pl.sp_status,pl.plan_id";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("SQL Prepare Failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ii", $mk_id, $u_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
}

function update_purchase_and_stock($shop_id, $shop_qty, $shop_price, $sp_status, $stock_date)
{
    global $conn;

    mysqli_begin_transaction($conn);

    try {
        // 1️⃣ อัปเดต sp_list
        $sql_update = "UPDATE sp_list 
                       SET shop_qty = ?, 
                           shop_price = ?, 
                           sp_status = ?, 
                           syn_stock = 1,
                           update_at = NOW() 
                       WHERE shop_id = ?";
        $stmt1 = mysqli_prepare($conn, $sql_update);
        if (!$stmt1) throw new Exception(mysqli_error($conn));
        mysqli_stmt_bind_param($stmt1, "dssi", $shop_qty, $shop_price, $sp_status, $shop_id);
        mysqli_stmt_execute($stmt1);

        // 2️⃣ ดึง pd_id, pu_id
        $sql_select = "SELECT pd_id, pu_id FROM sp_list WHERE shop_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql_select);
        mysqli_stmt_bind_param($stmt2, "i", $shop_id);
        mysqli_stmt_execute($stmt2);
        $result = mysqli_stmt_get_result($stmt2);
        $row = mysqli_fetch_assoc($result);
        if (!$row) throw new Exception("ไม่พบสินค้าที่ต้องการบันทึกสต็อก");

        $pd_id = $row['pd_id'];
        $pu_id = $row['pu_id'];

        // 3️⃣ เพิ่มเข้า stock
        $qty_in = $shop_qty;
        $qty_out = 0;
        $source_type = 'in';
        $balance = 0; // ชั่วคราว

        $sql_insert = "INSERT INTO stock (pd_id, pu_id, qty_in, qty_out, balance, source_type, ref_id, stock_date)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt3 = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt3, "iiiddsis", $pd_id, $pu_id, $qty_in, $qty_out, $balance, $source_type, $shop_id, $stock_date);
        mysqli_stmt_execute($stmt3);

        // 4️⃣ ปรับ balance อัตโนมัติ
        $sql_update_balance = "UPDATE stock s
                               JOIN (SELECT pd_id, SUM(qty_in)-SUM(qty_out) AS new_balance
                                     FROM stock
                                     WHERE pd_id = ?
                                     GROUP BY pd_id) t
                               ON s.pd_id = t.pd_id
                               SET s.balance = t.new_balance";
        $stmt4 = mysqli_prepare($conn, $sql_update_balance);
        mysqli_stmt_bind_param($stmt4, "i", $pd_id);
        mysqli_stmt_execute($stmt4);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log("Update failed: " . $e->getMessage());
        return false;
    }
}



//ทดสอบฟังก์ชัน update_purchase_and_stock ใหม่
function update_shop_and_stock($shop_id, $pd_id, $pu_id, $shop_qty, $shop_price, $sp_status)
{
    global $conn;

    // เริ่ม transaction
    mysqli_begin_transaction($conn);

    try {
        // 1️⃣ อัปเดตข้อมูลในตาราง sp_list
        $sql_update = "UPDATE sp_list 
                       SET shop_qty = ?, shop_price = ?, sp_status = ?, syn_stock = 1 
                       WHERE shop_id = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        if (!$stmt_update) {
            throw new Exception("Prepare failed (UPDATE): " . mysqli_error($conn) . "<br>SQL: " . $sql_update);
        }

        mysqli_stmt_bind_param($stmt_update, "ddsi", $shop_qty, $shop_price, $sp_status, $shop_id);
        if (!mysqli_stmt_execute($stmt_update)) {
            throw new Exception("Execute failed (UPDATE): " . mysqli_stmt_error($stmt_update) . "<br>SQL: " . $sql_update);
        }

        // 2️⃣ เพิ่มข้อมูลลงตาราง stock
        $sql_insert = "INSERT INTO stock (pd_id, pu_id, qty_in, qty_out, balance, source_type, ref_id, stock_date)
                       VALUES (?, ?, ?, 0, ?, 'in', ?, NOW())";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        if (!$stmt_insert) {
            throw new Exception("Prepare failed (INSERT): " . mysqli_error($conn) . "<br>SQL: " . $sql_insert);
        }

        mysqli_stmt_bind_param($stmt_insert, "iidii", $pd_id, $pu_id, $shop_qty, $shop_qty, $shop_id);
        if (!mysqli_stmt_execute($stmt_insert)) {
            throw new Exception("Execute failed (INSERT): " . mysqli_stmt_error($stmt_insert) . "<br>SQL: " . $sql_insert);
        }

        // ✅ ถ้าไม่มีข้อผิดพลาด ให้ commit
        mysqli_commit($conn);
        echo "<div style='color: green;'>บันทึกข้อมูลสำเร็จ</div>";
    } catch (Exception $e) {
        // ❌ ถ้ามีข้อผิดพลาด ให้ rollback และแสดงรายละเอียด
        mysqli_rollback($conn);
        echo "<div style='color: red;'>
                <strong>เกิดข้อผิดพลาด:</strong><br>" . $e->getMessage() . "
              </div>";
    }
}



// ดึง plan_id จาก shop_id
function get_plan_id_by_shop($shop_id)
{
    global $conn;
    $sql = "SELECT plan_id FROM sp_list WHERE shop_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $shop_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    return $row['plan_id'] ?? 0;
}

// ฟังก์ชันอัปเดต sp_list และ plan
function update_plan_syn($shop_id, $mk_id, $sp_id, $u_id, $pd_id, $note)
{
    global $conn;
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_begin_transaction($conn);

    try {
        // 1. อัปเดต sp_list โดยใช้ shop_id (PK)
        $sql1 = "UPDATE sp_list 
                 SET mk_id = ?, sp_id = ?, u_id = ?, pd_id = ?, note = ?
                 WHERE shop_id = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "iiiisi", $mk_id, $sp_id, $u_id, $pd_id, $note, $shop_id);
        mysqli_stmt_execute($stmt1);

        if (mysqli_stmt_affected_rows($stmt1) === 0) {
            throw new Exception("ไม่พบข้อมูลแผนที่ต้องการอัปเดตใน sp_list");
        }

        // 2. ดึง plan_id ของ shop_id นี้
        $plan_id = get_plan_id_by_shop($shop_id);
        if ($plan_id == 0) {
            throw new Exception("ไม่พบ plan_id ของ shop_id นี้");
        }

        // 3. อัปเดต syn_shopping = 2 ใน plan
        $sql2 = "UPDATE plan SET syn_shop = 2 WHERE plan_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "i", $plan_id);
        mysqli_stmt_execute($stmt2);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<h3>เกิดข้อผิดพลาด:</h3>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<p><a href='javascript:history.back()'>กลับไปหน้าเดิม</a></p>";
        return false;
    }
}



// ฟังก์ชัน: ดึงชื่อผู้รับผิดชอบใหม่จาก sp_list ตาม plan_id
function fetch_responsible_name_by_plan($plan_id)
{
    global $conn;

    $sql = "SELECT u.u_name 
            FROM sp_list AS sp
            JOIN js_user AS u ON sp.u_id = u.u_id
            WHERE sp.plan_id = ?
            LIMIT 1";  // ป้องกันดึงหลายแถว

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $plan_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row['u_name'];
    } else {
        return null;
    }
}



// รับข้อมูลสินค้าเข้า stock Tb-stock


function stock_in($pd_id, $pu_id, $qty, $ref_id, $date)
{
    global $conn;

    // 1. หา balance ล่าสุด
    $sql = "SELECT balance
            FROM stock
            WHERE pd_id=? AND pu_id=?
            ORDER BY stock_id DESC
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $pd_id, $pu_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $balance = $row['balance'] + $qty;
    } else {
        $balance = $qty;
    }

    // 2. insert stock movement
    $sql2 = "INSERT INTO stock
            (pd_id,pu_id,qty_in,qty_out,balance,source_type,ref_id,stock_date)
            VALUES (?,?,?,0,?,'in',?,?)";

    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param(
        $stmt2,
        "iiddis",
        $pd_id,
        $pu_id,
        $qty,
        $balance,
        $ref_id,
        $date
    );

    mysqli_stmt_execute($stmt2);
}


function check_plan_open($u_id)
{
    global $conn;

    $sql = "SELECT COUNT(*) AS total
            FROM sp_list
            WHERE u_id = ?
            AND syn_stock = 0
            AND is_close = 0";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $plan_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}


//-----------------------------status------------

//--update sp_status
function update_sp_status($pd_id, $sp_id, $status)
{

    global $conn;

    $sql = "UPDATE sp_list 
        SET sp_status=?,
        update_at=NOW() 
        WHERE pd_id=? and sp_id=? ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sii", $status, $pd_id, $sp_id);

    return mysqli_stmt_execute($stmt);
}

//---เปลี่ยนผู้ซื้อ
function update_sp_buyer($pd_id, $sp_id, $u_id, $status)
{

    global $conn;

    $sql = "UPDATE sp_list
        SET u_id=?,
            sp_status=?,
            update_at=NOW()
        WHERE pd_id=? and sp_id =?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "isii", $u_id, $status, $pd_id, $sp_id);

    return mysqli_stmt_execute($stmt);
}

function supp_save($mk_id, $sp_name, $sp_tel)
{
    global $conn;

    $sql = "INSERT INTO mk_sup(mk_id,sp_name,sp_tel) 
            VALUES (?, ?, ?)";
    // แปลง $sql เป็น $stmt            
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn);
        exit();
    }

    // ผูกค่าพารามิเตอร์
    mysqli_stmt_bind_param($stmt, "iss", $mk_id, $sp_name, $sp_tel);

    // ดำเนินการคำสั่ง SQL
    return mysqli_stmt_execute($stmt);
}

function check_sp_editable($pd_id, $sp_id)
{

    global $conn;

    $sql = "SELECT is_closed, syn_stock
        FROM sp_list
        WHERE pd_id=? AND sp_id=?";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . mysqli_error($conn);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $pd_id, $sp_id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);

    if ($row['is_closed'] == 1 || $row['syn_stock'] == 1) {
        return false;
    }

    return true;
}

// ----รายการซื้อสำเร็จ---------------
function syn_stock_list($created, $u_id)
{
    global $conn;

    $start = $created . " 00:00:00";
    $end   = $created . " 23:59:59";

    $sql = "SELECT 
                sp.pd_id,
                sp.shop_id,
                sp.shop_qty,
                sp.shop_price,
                (sp.shop_qty * sp.shop_price) AS total,
                p.pd_n,
                pu.pu_name,
                u.u_name,
                mp.sp_name
            FROM sp_list sp
            JOIN product p ON sp.pd_id = p.pd_id
            JOIN p_unit pu ON sp.pu_id = pu.pu_id
            JOIN js_user u on  sp.u_id = u.u_id
            JOIN mk_sup mp on sp.sp_id = mp.sp_id
            WHERE sp.syn_stock = 1
            AND sp.created_at BETWEEN ? AND ?
            AND sp.u_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssi", $start, $end, $u_id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return $result;
}
// --------แสดงยอดการซื้อสินค้า-------------------
function summary_syn_stock($created, $u_id)
{
    global $conn;

    $start = $created . " 00:00:00";
    $end   = $created . " 23:59:59";

    $sql = "SELECT 
                COUNT(*) as total_item,
                SUM(shop_qty) as total_qty,
                SUM(shop_qty*shop_price) as total_price,
                COUNT(DISTINCT mk_id) as total_market,
                COUNT(DISTINCT sp_id) as total_shop
            FROM sp_list
            WHERE syn_stock = 1
            AND created_at BETWEEN ? AND ?
            AND u_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "ssi", $start, $end, $u_id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

function return_save($pd_id, $shop_id, $pu_id, $qty, $note)
{
    global $conn;

    mysqli_begin_transaction($conn);

    try {

        // 🔹 1. ดึงข้อมูลเดิม + กันคืนซ้ำ
        $sql1 = "SELECT shop_qty, sp_status 
                 FROM sp_list
                 WHERE pd_id = ? AND shop_id = ?
                 FOR UPDATE";

        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "ii", $pd_id, $shop_id);
        mysqli_stmt_execute($stmt1);

        $result = mysqli_stmt_get_result($stmt1);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            throw new Exception("ไม่พบข้อมูล");
        }

        if ($row['sp_status'] == 'คืนสินค้า') {
            throw new Exception("รายการนี้ถูกคืนแล้ว");
        }

        $db_qty = $row['shop_qty'];

        // 🔹 2. validate qty
        if ($qty <= 0 || $qty > $db_qty) {
            throw new Exception("จำนวนคืนไม่ถูกต้อง");
        }

        // 🔹 3. update sp_list
        $sql2 = "UPDATE sp_list
                 SET sp_status = 'คืนสินค้า',
                     syn_stock = 0,
                     note = ?,
                     update_at = NOW()
                 WHERE pd_id = ?
                 AND shop_id = ?";

        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "sii", $note, $pd_id, $shop_id);
        mysqli_stmt_execute($stmt2);

        // 🔹 4. คำนวณ balance ล่าสุด
        $sql_balance = "SELECT balance 
                        FROM stock 
                        WHERE pd_id = ? 
                        ORDER BY stock_id DESC 
                        LIMIT 1";

        $stmt_balance = mysqli_prepare($conn, $sql_balance);
        mysqli_stmt_bind_param($stmt_balance, "i", $pd_id);
        mysqli_stmt_execute($stmt_balance);

        $res_balance = mysqli_stmt_get_result($stmt_balance);
        $last = mysqli_fetch_assoc($res_balance);

        $current_balance = $last ? $last['balance'] : 0;
        $new_balance = $current_balance - $qty;

        // 🔹 5. insert stock (คืนสินค้า = OUT)
        $sql3 = "INSERT INTO stock (
                    pd_id,
                    pu_id,
                    qty_in,
                    qty_out,
                    balance,
                    source_type,
                    ref_id,
                    stock_date
                ) VALUES (?, ?, 0, ?, ?, 'out', ?, NOW())";

        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param(
            $stmt3,
            "iidii",
            $pd_id,
            $pu_id,
            $qty,
            $new_balance,
            $shop_id
        );

        mysqli_stmt_execute($stmt3);

        mysqli_commit($conn);

        return true;
    } catch (Exception $e) {

        mysqli_rollback($conn);

        // debug (แนะนำเปิดตอน dev)
        // echo $e->getMessage();

        return false;
    }
}

//ดึงข้อมูลสินค้าและจำนวน ของลูกค้าแต่ละราย
function fetch_sp_list_by_pdspid($pd_id, $shop_id)
{
    global $conn;

    $sql = " SELECT sp.pd_id ,
                    pro.pd_n,
                    c.c_id,
                    c.c_abb,
                    p.sp_id,
                    p.sp_name,
                    sp.shop_qty,
                    pu.pu_id,
                    pu.pu_name,
                    od.dv_day,
                    sp.sp_status,
                    od.od_id,
                    sp.shop_price, 
                    sp.shop_id,
                    ROUND((sp.shop_qty) * (sp.shop_price), 2) AS total_price
    FROM sp_list AS sp 
    JOIN product as pro on sp.pd_id = pro.pd_id 
    JOIN p_unit as pu on sp.pu_id = pu.pu_id 
    JOIN orders AS od ON sp.od_id = od.od_id 
    JOIN cust AS c ON od.c_id = c.c_id
    join mk_sup as p on sp.sp_id = p.sp_id
     WHERE sp.pd_id = ? and sp.shop_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $pd_id, $shop_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return $result;
}

function get_delivery_list($c_id, $dv_day)
{
    global $conn;

    $sql = "SELECT 
        odd.od_id,
        odd.pd_id,
        odd.qty,
        c.c_name,
        cd.dp_name,
        p.pd_n,
        pu.pu_name,
        odd.od_detail,
        sp.sp_id,
        sp.sp_status,
        sp.is_closed,
        sp.syn_stock

    FROM orders_detail odd

    JOIN orders od 
        ON odd.od_id = od.od_id

    JOIN cust c 
        ON od.c_id = c.c_id

    JOIN c_depart cd 
        ON od.dp_id = cd.dp_id

    JOIN product p 
        ON odd.pd_id = p.pd_id

    JOIN p_unit pu 
        ON odd.pu_id = pu.pu_id

    LEFT JOIN sp_list sp 
        ON sp.od_id = odd.od_id 
        AND sp.pd_id = odd.pd_id

    WHERE od.c_id = ?
    AND od.dv_day = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "is", $c_id, $dv_day);

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}
