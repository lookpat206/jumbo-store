<?php
include('_fn.php');

if (isset($_POST['dv_day']) && !empty($_POST['dv_day'])) {
    $dv_day = $_POST['dv_day'];

    $date = DateTime::createFromFormat('m/d/Y', $dv_day);
    if ($date) {
        $dv_day_new = $date->format('d/m/Y');
        save_shopping($dv_day_new);
    } else {
        echo "รูปแบบวันที่ไม่ถูกต้อง";
    }
} else {
    echo "ไม่ได้รับข้อมูลวันที่";
}
