<?php
// shopping.php
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('../user/_fn.php');
include('_fn.php');

// เรียกข้อมูล
$sp_list_result = get_sp_list();





?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">

            <h4 class="text display-4">รายการซื้อสินค้า</h4>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text">สรุปรายการซื้อสินค้า</h4>

                        </div>
                        <!-- /.card-header -->
                        <form action="sp_add.php" method="post">
                            <div class="card-body">

                                <div class="form-group">

                                    <p style="color: red; font-size: smaller;">เลือกวันที่ส่งสินค้าจากปฏิทิน</p>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="dv_day" class="form-control datetimepicker-input" placeholder="mm/dd/yyy (เดือน/วัน/ปี) : 06/03/2025" data-target="#reservationdate" />

                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger">สรุปยอดสั่งซื้อสินค้า</button>


                            </div>
                        </form>




                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">รายการซื้อสินค้า</h1>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="table-info">
                                        <th width="5%">ลำดับ</th>
                                        <th width="10%">ตลาด</th>
                                        <th width="10%">ร้านค้า</th>

                                        <th width="10%">ผู้รับผิดชอบ</th>
                                        <th width="25%">สินค้า</th>
                                        <th width="5%">จำนวน</th>
                                        <th width="10%">หน่วยนับ</th>
                                        <th width="10%">ราคา</th>
                                        <th width="5%">รวม</th>
                                        <th width="5%">สถานะ</th>
                                        <th width="5%">แก้ไข</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($sp_list_result)):
                                        $i++;
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo htmlspecialchars($row['mk_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['sp_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['u_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['pd_n']); ?></td>
                                            <td><?php echo (int)$row['quantity']; ?></td>
                                            <td><?php echo htmlspecialchars($row['pu_name']); ?></td>
                                            <td><?php echo number_format($row['sp_price'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($row['total_price'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($row['sp_status']); ?></td>
                                            <td>
                                                <a class="btn btn-warning btn-sm" href="sp_edit.php?pl_id=<?= $row['pl_id'] ?>">
                                                    <i class="far fa-edit"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <?php endwhile;
                                    $grand_total = 0;
                                    if ($i > 0) {
                                        mysqli_data_seek($sp_list_result, 0); // Reset pointer to the start
                                        while ($row = mysqli_fetch_assoc($sp_list_result)) {
                                            $grand_total += $row['total_price'];
                                        }
                                    }

                                    ?>
                                    <?php

                                    // ตรวจสอบว่ามีรายการสินค้าหรือไม่        


                                    if ($i == 0) {
                                        echo "<tr><td colspan='9'>ยังไม่มีรายการสินค้า</td></tr>";
                                    }
                                    ?>
                                </tbody>
                                <?php if ($i > 0): ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8" align="right"><strong>รวมทั้งสิ้น</strong></td>
                                            <td><strong><?= number_format($grand_total, 2) ?></strong></td>
                                        </tr>
                                    </tfoot>
                                <?php endif; ?>
                            </table>
                        </div>


                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
<?php
if (isset($_GET['success']) && $_GET['success'] == 1 && isset($_GET['rows'])) {
    $rows = (int)$_GET['rows'];
    echo "
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'บันทึกสำเร็จ',
            text: 'จำนวน {$rows} รายการ',
            confirmButtonText: 'ตกลง'
        });
    });
    </script>
    ";
}
?>




<?php
include('_footer.php');
?>