<?php
//เปลี่ยนข้อมูลแผนการซื้อ : ร้านค้า ผู้รับผิดชอบ ตลาด
//แก้ไขสถานะการซื้อสินค้าและหมายเหตุ

?>
<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');
include('../admin/_fn.php');

//ดึงข้อมูล สถานที่ซื้อสินค้า , ร้านค้า , สินค้า , ผู้รับผิดชอบ เพื่อใช้ในการเลือกข้อมูล

$result2 = fetch_supp();
$result3 = fetch_prod();
$result4 = fetch_user();
$result5 = fetch_mark();


//รับค่า id จาก plan.php
$pd_id = $_GET['pd_id'];
//$plan_id = $_GET['plan_id'];

$result = fetch_product_by_prodid($pd_id);
$row = mysqli_fetch_assoc($result);
$pd_name = $row['pd_n'];

$result6 = fetch_sp_list_by_pdid($pd_id);
$row1 = mysqli_fetch_assoc($result6);

//echo $pd_id . $sp_id;  //debug




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
                            <h3 class="card-title">แก้ไขข้อมูลการซื้อ : <?= $pd_name ?></h3>
                        </div>
                        <form action=".php" method="post">
                            <div class="card-body">
                                <input type="hidden" name="pd_id" value="<?= $pd_id ?>">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- ชื่อสินค้า -->
                                        <div class="form-group">
                                            <label>สินค้า</label>
                                            <input type="text" class="form-control" placeholder="<?= $pd_n ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>หน่วยนับ</label>
                                            <input type="text" class="form-control" placeholder="<?= $pu_name ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- จำนวนสินค้า-->
                                        <div class="form-group">
                                            <label>จำนวนสินค้า</label>
                                            <input type=" number" class="form-control" name="quantity" step="0.01" min="0" placeholder="<?= $quantity ?>">
                                            <small class="form-text text-danger">ใส่ทศนิยม 2 ตำแหน่ง</small>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>ราคาซื้อสินค้า</label>
                                            <input type=" number" class="form-control" name="sp_price" step="0.01" min="0" placeholder="<?= $sp_price ?>">
                                            <small class="form-text text-danger">ใส่ทศนิยม 2 ตำแหน่ง</small>

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>สถานะ</label>
                                            <select multiple class="form-control" name="sp_status" style="width: 100%;">
                                                <option value="<?= $sp_status ?>">รอจัดส่ง</option>
                                                <option value="1">ไม่มีสินค้า</option>
                                                <option value="2">รอสินค้าวันต่อไป</option>
                                                <option value="3"></option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- หมายเหตุ เมื่อเปลี่ยนร้าน or ผู้รับผิดชอบ -->
                                        <div class="form-group">
                                            <label>หมายเหตุ</label>
                                            <textarea class="form-control" rows="3" placeholder="บอกสาเหตุการที่ไม่สามารสซื้อสินค้า : ซื้อร้านใหม่ เปลี่ยนให้ใครซื้อ "></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- /.card-body -->

                            <!-- บันทึก -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger">บันทึก</button>
                                <a href="pl.php" class="btn btn-secondary">กลับ</a>
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