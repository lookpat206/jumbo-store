<?php
//ลบ รหัสและชื่อสินค้า  : เชื่อมหลาย TB

include('_fn.php');

$pd_id = $_GET['pd_id'];

prod_delete($pd_id);
