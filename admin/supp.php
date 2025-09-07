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
                    <h1>ข้อมูลร้านค้า</h1>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ข้อมูลร้านค้า</h3>
                            <div class="card-tools">
                                <a href="supp_add.php" class="btn btn-primary">เพิ่มข้อมูลร้านค้า</a>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">

                                <thead>
                                    <tr class="table-info">
                                        <th width="5%">ลำดับ</th>
                                        <th width="30%">ชื่อร้านค้า</th>
                                        <th width="20%">ประเภทสินค้า</th>
                                        <th width="25%">เบอร์โทรศัพท์</th>
                                        <th width="10%">แก้ไข</th>
                                        <th width="10%">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $result = fetch_supp();
                                    if (mysqli_num_rows($result) > 0) {
                                        $i = 0;
                                        foreach ($result as $row) {
                                            $i++;
                                    ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row['sp_name'] ?></td>
                                                <td><?= $row['pt_name'] ?></td>
                                                <td><?= $row['sp_tel'] ?></td>

                                                <td>
                                                    <a class="btn btn-warning btn-sm" href="supp_edit.php?sp_id=<?= $row['sp_id'] ?>">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm" href="supp_delete.php?sp_id=<?= $row['sp_id'] ?>">
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