<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');
include('../user/_fn.php');

//ดึงข้อมูล สถานที่ซื้อสินค้า , ร้านค้า , สินค้า , ผู้รับผิดชอบ เพื่อใช้ในการเลือกข้อมูล
$result1 = fetch_prod();
$result2 = fetch_cust();


//รับค่า id จาก plan.php
$pd_id = $_GET['pd_id'];

//exit($pl_id);
$result = fetch_sp_list_by_pdid($pd_id);
$row = mysqli_fetch_assoc($result);
$pd_n = $row['pd_n'];


?>

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
                            <h3 class="card-title">ชื่อสินค้า : <?= $pd_n ?></h3>
                        </div>
                        <form action="sp_edit_save.php" method="post">
                            <div class="card-body">
                                <input type="hidden" name="pd_id" value="<?= $pd_id ?>">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-info" style="text-align: center;">
                                            <th width="10%">ลำดับ</th>
                                            <th width="40%">ลูกค้า</th>
                                            <th width="15%">หน่วยนับ</th>
                                            <th width="15%">จำนวน</th>
                                            <th width="20%">สถานะ</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // ดึงข้อมูล ปริมาณการสั่งซื้อสินค้า
                                        $result1 = fetch_sp_list_by_pdid($pd_id);
                                        if (mysqli_num_rows($result1) > 0) {
                                            $i = 0;
                                            foreach ($result1 as $row) {
                                                $i++;
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <!-- ลูกค้า -->
                                                    <td><?= $row['c_abb'] ?></td>
                                                    <input type="hidden" name="c_id" value="<?= $row['c_id'] ?>">
                                                    <!-- หน่วยนับ -->
                                                    <td><?= $row['pu_name'] ?></td>
                                                    <!-- จำนวน -->
                                                    <td><?= $row['shop_qty'] ?></td>
                                                    <!-- สถานะ -->
                                                    <td><?= $row['sp_status'] ?></td>

                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="6">ไม่พบข้อมูล</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div> <!-- /.card-body -->

                            <!-- บันทึก -->
                            <div class="card-footer">

                                <a href="shopping.php" class="btn btn-secondary">กลับ</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
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
<!-- /.content-wrapper -->




<?php
include('_footer.php');
?>