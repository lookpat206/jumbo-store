<?php
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('_fn.php');


$result2 = fetch_supp();
$result3 = fetch_prod();
$result4 = fetch_user();

?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>แผนการซื้อสินค้า</h1>
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
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">สร้างแผนการซื้อสินค้า</small></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="plan_add_save.php" method="post">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="type">ร้านค้า:</label>
                                            <select class="form-control select2" name="sp_id" style="width: 100%;">
                                                <option selected="selected" value="">-- เลือกข้อมูล --</option>
                                                <?php foreach ($result2 as $row) { ?>
                                                    <option value="<?= $row['sp_id'] ?>"> <?= $row['sp_name'] ?> </option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="type">ชื่อสินค้า:</label>
                                            <select class="form-control select2" name="pd_id" style="width: 100%;">
                                                <option selected="selected" value="">-- เลือกข้อมูล --</option>
                                                <?php foreach ($result3 as $row) { ?>
                                                    <option value="<?= $row['pd_id'] ?>"> <?= $row['pd_n'] ?> </option>
                                                <?php } ?>

                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="type">ผู้รับผิดชอบ :</label>
                                            <select class="form-control select2" name="u_id" style="width: 100%;">
                                                <option selected="selected" value="">-- เลือกข้อมูล --</option>
                                                <?php foreach ($result4 as $row) { ?>
                                                    <option value="<?= $row['u_id'] ?>"> <?= $row['u_name'] ?> </option>
                                                <?php } ?>

                                            </select>

                                        </div>

                                    </div>

                                </div> <!-- /.row -->
                            </div> <!-- /.card-body -->

                            <!-- บันทึก -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger">บันทึก</button>
                            </div><!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">ข้อมูลแผนการซื้อสินค้า</h3>
                            <div class="card-tools"></div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">

                                <thead>
                                    <tr class="table-info">
                                        <th width="5%">ลำดับ</th>
                                        <th width="20%">สถานที่ซื้อสินค้า</th>
                                        <th width="20%">ชื่อร้านค้า</th>
                                        <th width="20%">สินค้า</th>
                                        <th width="15%">ผู้รับผิดชอบ</th>
                                        <th width="10%">แก้ไข</th>
                                        <th width="10%">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $result = fetch_plan();
                                    if (mysqli_num_rows($result) > 0) {
                                        $i = 0;
                                        foreach ($result as $row) {
                                            $i++;
                                    ?>
                                            <tr>
                                                <td><?= $row['plan_id'] ?></td>
                                                <td><?= $row['mk_name'] ?></td>
                                                <td><?= $row['sp_name'] ?></td>
                                                <td><?= $row['pd_n'] ?></td>
                                                <td><?= $row['u_name'] ?></td>

                                                <td>
                                                    <a class="btn btn-warning btn-sm" href="plan_edit.php?plan_id=<?= $row['plan_id'] ?>">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm" href="plan_delete.php?plan_id=<?= $row['plan_id'] ?>">
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