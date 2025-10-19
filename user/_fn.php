<?php
// user/_fn.php
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


// ฟังก์ชันเพิ่มรายการสินค้า
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
    $sql = "SELECT pd.pd_n, pu.pu_name, d.qty, d.price_s, d.total,d.ord_id
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

// ฟังก์ชันยืนยันใบสั่งซื้อ เปลี่ยนสถานะเป็น "จัดส่งสำเร็จ"
function confirm_po($od_id)
{
    global $conn;
    $sql = "UPDATE orders SET status_id = 'จัดส่งสำเร็จ' WHERE od_id = ?";
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




// ดึงรายละเอียดสินค้าในตลาดของผู้ใช้
function get_market_details($mk_id, $u_id)
{
    global $conn;

    $sql = "SELECT 
                pl.sp_status,
                pl.pd_id, 
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
            WHERE sup.mk_id = ? AND pl.u_id = ?
            GROUP BY pl.pd_id, pl.sp_id, sup.sp_name, p.pd_n, pu.pu_id, pl.sp_status";

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

    // เริ่ม transaction เพื่อให้ update / insert สำเร็จพร้อมกัน
    mysqli_begin_transaction($conn);

    try {
        // 1️⃣ อัปเดตตาราง sp_list
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

        // ตรวจสอบว่ามีการอัปเดตจริงหรือไม่
        if (mysqli_stmt_affected_rows($stmt1) <= 0) {
            throw new Exception("ไม่พบข้อมูลที่ต้องการอัปเดต");
        }

        // ดึงข้อมูล pd_id, pu_id จาก sp_list สำหรับบันทึก stock
        $sql_select = "SELECT pd_id, pu_id FROM sp_list WHERE shop_id = ?";
        $stmt2 = mysqli_prepare($conn, $sql_select);
        mysqli_stmt_bind_param($stmt2, "i", $shop_id);
        mysqli_stmt_execute($stmt2);
        $result = mysqli_stmt_get_result($stmt2);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            throw new Exception("ไม่พบสินค้าที่ต้องการบันทึกสต็อก");
        }

        $pd_id = $row['pd_id'];
        $pu_id = $row['pu_id'];

        // 2️⃣ เพิ่มข้อมูลเข้า stock
        $qty_in = $shop_qty;
        $qty_out = 0;
        $balance = $shop_qty;
        $source_type = 'in';

        $sql_insert = "INSERT INTO stock 
            (pd_id, pu_id, qty_in, qty_out, balance, source_type, ref_id, stock_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt3 = mysqli_prepare($conn, $sql_insert);
        if (!$stmt3) throw new Exception(mysqli_error($conn));

        mysqli_stmt_bind_param(
            $stmt3,
            "iiiddsis",
            $pd_id,
            $pu_id,
            $qty_in,
            $qty_out,
            $balance,
            $source_type,
            $shop_id,
            $stock_date
        );
        mysqli_stmt_execute($stmt3);

        // ✅ ถ้าทุกอย่างสำเร็จ
        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        // ❌ ถ้ามี error ให้ rollback
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




// ===============================================
// เมื่อซื้อสำเร็จ → ย้ายข้อมูลเข้า prod_stock และเคลียร์ pd_id
// ===============================================

//บันทึกข้อมูลเข้า prod_stock
function save_to_prod_stock($pd_id, $sp_id, $quantity, $unit_price, $unit_id, $status)
{
    global $conn;

    $sql = "INSERT INTO prod_stock (pd_id, sp_id, quantity, unit_price, unit_id, status) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "iiddis", $pd_id, $sp_id, $quantity, $unit_price, $unit_id, $status);
    mysqli_stmt_execute($stmt);
    $success = mysqli_stmt_affected_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    return $success;
}

// เคลียร์ pd_id ในตาราง sp_list  clear_pd_id_in_sp_list
function update_syn_status($pd_id)
{
    global $conn;

    $sql = "UPDATE sp_list 
            SET syn_stock = 1 ,sp_status = 'ซื้อสำเร็จ' 
            WHERE pd_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $pd_id);
    mysqli_stmt_execute($stmt);
    $success = mysqli_stmt_affected_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    return $success;
}

// ยืนยันการซื้อสินค้า: บันทึกข้อมูลเข้า prod_stock และเคลียร์ pd_id ใน sp_list
function complete_purchase($pd_id, $sp_id, $quantity, $unit_price, $unit_id)
{
    global $conn;
    mysqli_begin_transaction($conn);
    $status = "ซื้อสำเร็จ";

    try {
        $save = save_to_prod_stock($pd_id, $sp_id, $quantity, $unit_price, $unit_id, $status);
        $clear = update_syn_status($pd_id);

        if ($save && $clear) {
            mysqli_commit($conn);
            return true;
        } else {
            mysqli_rollback($conn);
            return false;
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return false;
    }
}
