
<?php
include('_fn.php');

// Validate ว่ามีค่า POST ส่งมาไหม
if (isset($_POST['pl_id'], $_POST['mk_id'], $_POST['sp_id'], $_POST['u_id'], $_POST['quantity'], $_POST['sp_price'], $_POST['sp_status'])) {

    // แปลงค่าเป็นประเภทที่เหมาะสม
    $pl_id = $_POST['pl_id'];
    $mk_id = $_POST['mk_id'];
    $sp_id = $_POST['sp_id'];
    $u_id = $_POST['u_id'];
    $quantity = $_POST['quantity'];
    $sp_price = $_POST['sp_price'];
    $sp_status = $_POST['sp_status']; // ป้องกัน XSS
    print_r($_POST); // สำหรับดีบัก
    // เรียก function update
    $result = sp_list_edit($pl_id, $mk_id, $sp_id, $u_id, $quantity, $sp_price, $sp_status);

    if ($result) {
        header("Location:shopping.php?success=1"); // redirect หลังบันทึกสำเร็จ
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }
} else {
    echo "ข้อมูลไม่ครบถ้วน กรุณาตรวจสอบ!";
    print_r($_POST); // สำหรับดีบัก
}
?>

