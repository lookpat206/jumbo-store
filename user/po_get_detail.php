<?php
session_start();


include('_fn.php');

if (isset($_GET['od_id'])) {
    $od_id = $_GET['od_id'];

    // ดึงข้อมูลใบสั่งซื้อ
    $order = get_order_by_id($od_id);
    if (!$order) {
        echo "ไม่พบใบสั่งซื้อที่ระบุ";
        exit;
    }

    // ดึงรายละเอียดสินค้าในใบสั่งซื้อ
    $order_details = get_orders_detail($od_id);
} else {
    echo "ไม่มีรหัสใบสั่งซื้อ";
    exit;
}

// ถ้า get_order_by_id คืนมาเป็น array
$row1 = $order;

$od_id   = $row1['od_id'];
$c_name  = $row1['c_name'];
$c_add   = $row1['c_add'];
$c_tel   = $row1['c_tel'];
$od_day  = $row1['od_day'];
$dv_day  = $row1['dv_day'];
$dv_time = $row1['dv_time'];
$od_note = $row1['od_note'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Invoice</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper Content">
        <div class="Content">
            <div class="content-header">

            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-10 mx-auto">
                        <div class="callout callout-info">
                            <h5><i class="fas fa-info"></i> Note:</h5>
                            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
                        </div>


                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h3>
                                        ร้านจัมโบ้อาหารสด
                                        <?php date_default_timezone_set("Asia/Bangkok"); ?>
                                        <small class="float-right">Date: <?= date("d/m/Y") ?></small>
                                    </h3>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>


                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    ถึง
                                    <address>
                                        <strong><?= htmlspecialchars($c_name) ?></strong><br>
                                        <?= nl2br(htmlspecialchars($c_add)) ?><br>
                                        Phone: <?= htmlspecialchars($c_tel) ?><br>
                                        <!-- Email:  -->
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Order ID:</b> <?= htmlspecialchars($od_id) ?><br>
                                    <b>Orders date:</b> <?= htmlspecialchars($od_day) ?><br>
                                    <b>Delivery date:</b> <?= htmlspecialchars($dv_day) ?><br>
                                    <b>Delivery time:</b> <?= htmlspecialchars($dv_time) ?><br>
                                    <b>Note:</b> <?= htmlspecialchars($od_note) ?><br>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="table-info">
                                                <th width="10%">ลำดับ</th>
                                                <th width="40%">สินค้า</th>
                                                <th width="20%">หน่วยนับ</th>
                                                <th width="20%">จำนวน</th>
                                                <th width="20%">ราคาต่อหน่วย</th>
                                                <th width="20%">รวม</th>


                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $details = get_orders_detail($od_id);
                                            $i = 0;
                                            $grand_total = 0;
                                            //$ord_id = $row['ord_id']; // สมมติชื่อ PK ในตารางคือ odr_id


                                            while ($row = mysqli_fetch_assoc($details)) {
                                                $i++;
                                                $grand_total += $row['total'];
                                                $ord_id = $row['ord_id']; // สมมติชื่อ PK ในตารางคือ ord_id

                                                echo "<tr>
                                                <td>{$i}</td>
                                                <td>{$row['pd_n']}</td>
                                                <td>{$row['pu_name']}</td>
                                                <td>{$row['qty']}</td>
                                                <td>" . number_format($row['price_s'], 2) . "</td>
                                                <td>" . number_format($row['total'], 2) . "</td>
                                                
                                            </tr>";
                                            }

                                            if ($i == 0) {
                                                echo "<tr><td colspan='7'>ยังไม่มีรายการสินค้า</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                        <?php if ($i > 0): ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" align="right"><strong>รวมทั้งสิ้น</strong></td>
                                                    <td><strong><?= number_format($grand_total, 2) ?></strong></td>
                                                </tr>
                                            </tfoot>
                                        <?php endif; ?>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->



                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12 text-right">
                                    <a href="po.php" class="btn btn-secondary">Back</a>
                                </div>
                            </div>

                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    include('_footer.php');
    ?>