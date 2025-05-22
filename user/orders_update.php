<?php
session_start();
// ตรวจสอบว่ามีการส่งข้อมูล POST มาหรือไม่

require_once '_fn.php'; // เรียกไฟล์ที่มีฟังก์ชัน get_departments_by_customer()

if (isset($_POST['c_id']) && !empty($_POST['c_id'])) {
    $c_id = $_POST['c_id'];
    $result = get_departments_by_customer($c_id);

    echo '<option value="">-- เลือกแผนก/ครัว --</option>';
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['dp_id']}'>" . htmlspecialchars($row['dp_name']) . "</option>";
        }
    }
}
