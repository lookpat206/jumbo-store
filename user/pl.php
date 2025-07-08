<?php
session_start();
// product list รายการซื้อสินค้า
include('_header.php');
//include('_sidebar_menu.php');
include('_fn.php');

// ตรวจสอบว่ามีการ login แล้วหรือไม่ และ u_id ถูกเก็บไว้ใน session หรือไม่
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit;
}

$u_id = $_SESSION['u_id'];
//print_r($u_id); // แสดงค่า u_id สำหรับดีบัก

$markets = fetch_market_byuid($u_id); // ดึงข้อมูลตลาดที่ซื้อสินค้า
print_r($markets); // แสดงข้อมูลตลาดสำหรับดีบัก

?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รายการซื้อสินค้า</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">

                <!-- แสดงสถานที่ซื้อสินค้า -->
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title ">สถานที่ซื้อสินค้า</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            <?php foreach ($markets as $market): ?>
                                <li class="nav-item">
                                    <a class="nav-link">
                                        <?= htmlspecialchars($market['mk_name']) ?>
                                        <!-- ถ้าอยากใส่จำนวน สามารถเพิ่ม badge ได้ เช่น -->
                                        <!-- <span class="badge bg-primary float-right">10</span> -->
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- แสดงสถานะการซื้อสินค้า -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">สถานะ</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a class="nav-link">
                                    ไม่มีสินค้า
                                    <span class="badge bg-danger float-right">65</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    รอสินค้า
                                    <span class="badge bg-warning float-right">65</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    ซื้อสินค้าสำเร็จ
                                    <span class="badge bg-success float-right">65</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <!-- เริ่มส่วน Tab -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#shop1" data-toggle="tab">ร้าน 1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#shop2" data-toggle="tab">ร้าน 2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#shop3" data-toggle="tab">ร้าน 3</a>
                            </li>
                        </ul>
                    </div>

                    <!-- เริ่มเนื้อหา Tab -->
                    <div class="card-body">
                        <div class="tab-content">

                            <!-- ร้าน 1 -->
                            <div class="tab-pane fade show active" id="shop1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="table-info">
                                                    <th>ลำดับ</th>
                                                    <th>ชื่อสินค้า</th>
                                                    <th>จำนวน</th>
                                                    <th>ราคา</th>
                                                    <th>แก้ไขรายการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>สินค้า A</td>
                                                    <td>2</td>
                                                    <td>100 บาท</td>
                                                    <td>
                                                        <a href="#" class="btn btn-warning btn-sm">แก้ไข</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- ร้าน 2 -->
                            <div class="tab-pane fade" id="shop2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="table-info">
                                                    <th>ลำดับ</th>
                                                    <th>ชื่อสินค้า</th>
                                                    <th>จำนวน</th>
                                                    <th>ราคา</th>
                                                    <th>แก้ไขรายการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>สินค้า B</td>
                                                    <td>5</td>
                                                    <td>250 บาท</td>
                                                    <td>
                                                        <a href="#" class="btn btn-warning btn-sm">แก้ไข</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- ร้าน 3 -->
                            <div class="tab-pane fade" id="shop3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="table-info">
                                                    <th>ลำดับ</th>
                                                    <th>ชื่อสินค้า</th>
                                                    <th>จำนวน</th>
                                                    <th>ราคา</th>
                                                    <th>แก้ไขรายการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>สินค้า C</td>
                                                    <td>3</td>
                                                    <td>180 บาท</td>
                                                    <td>
                                                        <a href="#" class="btn btn-warning btn-sm">แก้ไข</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- /.tab-content -->
                    </div> <!-- /.card-body -->

                </div> <!-- /.card -->
            </div>

            <!-- /.col -->
            <!-- /.card -->
        </div>
        <!-- /.col -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>

<?php
include('_footer.php');
?>