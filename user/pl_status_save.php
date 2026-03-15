<?php
session_start();
include('_fn.php');   // ต้องมี $conn และ function ต่างๆ

// ตรวจสอบว่าเป็น POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: pl.php");
    exit();
}

// รับค่าจาก form
$pd_id  = $_POST['pd_id'] ?? null;
$sp_id  = $_POST['sp_id'] ?? null;
$status = $_POST['sp_status'] ?? null;

$result = false;

// ตรวจสอบค่าพื้นฐาน
if (!$pd_id || !$sp_id || !$status) {
    $error = "ข้อมูลไม่ครบ";
} else {

    switch ($status) {

        case 'รอสินค้า':

            $result = update_sp_status($pd_id, $sp_id, $status);

            break;


        case 'เปลี่ยนผู้ซื้อ':

            $u_id = $_POST['u_id'] ?? null;

            if (!$u_id) {
                $error = "กรุณาเลือกผู้ซื้อ";
                break;
            }

            $result = update_sp_buyer($pd_id, $sp_id, $u_id, $status);

            break;


        case 'เปลี่ยนร้าน':

            $mk_id   = $_POST['mk_id'] ?? null;
            $sp_name = $_POST['sp_name'] ?? null;
            $sp_tel  = $_POST['sp_tel'] ?? null;

            if (!$mk_id || !$sp_name) {
                $error = "ข้อมูลร้านไม่ครบ";
                break;
            }

            // update status
            update_sp_status($pd_id, $sp_id, $status);

            // insert ร้านใหม่
            $result = supp_save($mk_id, $sp_name, $sp_tel);

            break;


        default:
            $error = "สถานะไม่ถูกต้อง";
            break;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php if ($result) { ?>

        <script>
            Swal.fire({
                icon: 'success',
                title: 'บันทึกสำเร็จ',
                text: 'ระบบบันทึกสถานะเรียบร้อยแล้ว'
            }).then(function() {
                window.location = 'pl.php'
            })
        </script>

    <?php } else { ?>

        <script>
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: '<?= $error ?? "ไม่สามารถบันทึกข้อมูลได้" ?>'
            }).then(function() {
                window.location = 'pl.php'
            })
        </script>

    <?php } ?>

</body>

</html>