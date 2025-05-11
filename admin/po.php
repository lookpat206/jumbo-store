<?php
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('_fn.php');



?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ข้อมูลใบสั่งซื้อสินค้า</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li> -->
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) จำนวนลูกค้า -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3>รอข้อมูล</h3>

                            <p>จำนวนสถานที่ซื้อสินค้า</p>
                        </div>
                        <!-- <div class="icon">
                <i class="ion-android-person"></i>
              </div> -->
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                <div class="col-lg-3 col-6">
                    <!-- small box จำนวนสินค้า-->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>รอข้อมูล<!--<sup style="font-size: 20px">%</sup> --></h3>

                            <p>จำนวนร้านค้า</p>
                        </div>
                        <!-- <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div> -->
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                <div class="col-lg-3 col-6">
                    <!-- small box จำนวนผู้ใช้ -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>รอข้อมูล</h3>

                            <p>จำนวนสินค้า</p>
                        </div>
                        <!-- <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>  -->
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                <div class="col-lg-3 col-6">
                    <!-- small box จำนวนผู้ใช้ -->
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>รอข้อมูล</h3>

                            <p>จำนวนผู้รับผิดชอบ</p>
                        </div>
                        <!-- <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>  -->
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->




            </div>
            <!-- /.row -->

        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ใบสั่งซื้อสินค้า</h3>
                            <div class="card-tools">
                                <a href="order.php" class="btn btn-primary">สร้างใบสั่งซื้อ</a>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">

                                <thead>
                                    <tr class="table-info">
                                        <th width="10%">ลำดับ</th>
                                        <th width="15%">เลขที่ใบสั่งซื้อ</th>
                                        <th width="15%">ลูกค้า</th>
                                        <th width="15%">วันที่สั่ง</th>
                                        <th width="15%">วันที่ส่ง</th>
                                        <th width="20%">สถานะ</th>
                                        <th width="5%">รายละเอียด</th>
                                        <th width="5%">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $result = fetch_order();
                                    if (mysqli_num_rows($result) > 0) {
                                        $i = 0;
                                        foreach ($result as $row) {
                                            $i++;
                                    ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row['od_id'] ?></td>
                                                <td><?= $row['c_name'] ?></td>
                                                <td><?= $row['od_day'] ?></td>
                                                <td><?= $row['dv_day'] ?></td>
                                                <td><?= $row['od_status'] ?></td>
                                                <td>
                                                    <a class="btn btn-info btn-sm" href="order_detail.php?od_id=<?= $row['od_id'] ?>">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm" href="po_delete.php?od_id=<?= $row['od_id'] ?>">
                                                        <i class="far fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                        echo '<tr><td colspan="5">ไม่พบข้อมูล</td></tr>';
                                    }



                                    ?>
                                </tbody>

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
<!-- /.content-wrapper -->




<?php
include('_footer.php');
?>