<?php
// product list รายการซื้อสินค้า
include('_header.php');
include('_sidebar_menu.php');
include('_fn.php');



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
                            <li class="nav-item active">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-inbox"></i> Inbox
                                    <span class="badge bg-primary float-right">12</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-envelope"></i> Sent
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-file-alt"></i> Drafts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-filter"></i> Junk
                                    <span class="badge bg-warning float-right">65</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-trash-alt"></i> Trash
                                </a>
                            </li>
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
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <!-- ชื่อร้านค้า -->
                        <!-- href ="#activity" เชื่อมกับ id="activity" -->
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#shpo1" data-toggle="tab">ร้าน1</a></li>
                            <li class="nav-item"><a class="nav-link " href="#shop2" data-toggle="tab">ร้าน2</a></li>
                            <li class="nav-item"><a class="nav-link " href="#shop3" data-toggle="tab">ร้าน3</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">

                            <!-- อันดับแรกคือการแสดงข้อมูลกิจกรรมของผู้ใช้ -->

                            <div class="active tab-pane" id="shpo1">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="example1" class="table table-bordered table-striped">
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
                            <!-- /.tab-pane -->
                            <!-- อันที่ 2  -->
                            <div class="tab-pane" id="shop2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="example1" class="table table-bordered table-striped">
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
                            <!-- /.tab-pane -->
                            <div class="active tab-pane" id="shop3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="example1" class="table table-bordered table-striped">
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
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
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