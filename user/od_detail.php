<?php
session_start();
require_once '_fn.php';

//เพิ่มรายการสั่งซื้อและแสดงข้อมูลการสั่งซื้อ

// ตรวจสอบว่ามีการสร้างใบสั่งซื้อหรือไม่


if (!isset($_SESSION['od_id']) || !isset($_SESSION['c_id'])) {
    echo "กรุณาสร้างใบสั่งซื้อก่อน";

    exit;
}

$od_id = $_SESSION['od_id'];
$c_id = $_SESSION['c_id'];
$alert = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pd_id = $_POST['pd_id'];
    $pu_id = $_POST['pu_id'];
    $qty = $_POST['qty'];
    $c_id = $_POST['c_id'];


    $price_s = get_price($pd_id, $pu_id, $c_id);
    //print_r($price_s);
    // ตรวจสอบว่าเจอราคาหรือไม่
    // เช็คราคาว่าดึงได้ไหม
    if ($price_s === false) {
        $alert = "ไม่สามารถเพิ่มสินค้าได้: ไม่พบราคาสำหรับสินค้านี้ หน่วยนับ หรือรหัสลูกค้า";
    } else {
        $total = $price_s * $qty;
        if (add_po_detail($od_id, $pd_id, $pu_id, $qty, $price_s, $total)) {
            $alert = "เพิ่มสินค้าเรียบร้อยแล้ว";
        } else {
            $alert = "เกิดข้อผิดพลาดในการเพิ่มสินค้า";
        }
    }
}

include('../admin/_header.php');
//print_r($_POST);

?>

<body>

    <body class="">
        <div class="content">
            <!-- Content Header (Page header)  -->
            <section class="content-header">
                <!--<div class="container-fluid">
        <div class="row mb-2">
          <div class="col-6 mx-auto">
            <h1>ข้อมูลลูกค้า</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div> /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 mx-auto">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">เพิ่มรายการสินค้า</h3>
                                </div>
                                <form method="post">
                                    <input type="hidden" name="c_id" value="<?= $c_id ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- ชื่อสินค้า -->
                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label>ชื่อสินค้า : </label>

                                                        <select class=" form-control select2" name="pd_id">
                                                            <?php
                                                            $products = get_prod();
                                                            while ($row = mysqli_fetch_assoc($products)) {
                                                                echo "<option value='{$row['pd_id']}'>{$row['pd_n']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <!-- เลือกหน่วยนับ -->
                                                    <div class="mb-3">
                                                        <label>หน่วยนับ : </label>
                                                        <select class=" form-control select2" name="pu_id">
                                                            <?php
                                                            $units = get_units();
                                                            while ($row = mysqli_fetch_assoc($units)) {
                                                                echo "<option value='{$row['pu_id']}'>{$row['pu_name']}</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">

                                                    <!-- จำนวนสินค้า -->
                                                    <div class="mb-3">
                                                        <label>จำนวน : </label>
                                                        <input type=" number" class="form-control" name="qty" step="0.01" min="0" required>
                                                        <small class="form-text text-danger">ใส่ทศนิยม 2 ตำแหน่ง</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--  /.row -->
                                    </div> <!-- /.card-body -->
                                    <!-- บันทึก -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-danger">เพิ่มรายการสินค้า</button>

                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 mx-auto">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">ข้อมูลราคาสินค้า</h3>
                                    <?php if (!empty($alert)) : ?>
                                        <div class="alert alert-warning">
                                            <?= $alert ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="table-info">
                                                <th width="10%">ลำดับ</th>
                                                <th width="40%">สินค้า</th>
                                                <th width="20%">หน่วยนับ</th>
                                                <th width="20%">จำนวน</th>
                                                <th width="20%">ราคาต่อหน่วย</th>
                                                <th width="20%">รวม</th>
                                                <th width="10%">ลบรายการ</th>

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
                                                        <td>
                                                            <a href='od_detail_delete.php?ord_id=$ord_id' class='btn btn-danger btn-sm'
                                                                onclick=\"return confirm('คุณต้องการลบรายการนี้หรือไม่?')\">
                                                                <i class='far fa-trash-alt'></i> ลบ
                                                            </a>
                                                        </td>
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



                                </div><!-- /.card-body -->
                                <div class="card-footer">
                                    <a href="od_confirm.php" class="btn btn-success" onclick="return confirm('ยืนยันการสั่งซื้อหรือไม่?')">
                                        ยืนยันการสั่งซื้อ
                                    </a>
                                </div>

                            </div><!-- /.card -->

                        </div> <!-- /.col -->

                    </div><!-- /.row -->
                </div>
        </div>
        <!-- /.container-fluid -->

        </section>
        </div> <!-- /.content -->


        <?php
        include('_footer.php');
        ?>