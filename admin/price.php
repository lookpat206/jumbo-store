<?php
// ติดปัญหาบันทึกข้อมูล
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

// GET c_id by cust.php
$c_id = $_GET['c_id'];



// เรียกใช้ function 
$result = fetch_cust_by_cid($c_id);
$row = mysqli_fetch_assoc($result);
$c_name = $row['c_name'];
$c_abb = $row['c_abb'];

//echo $c_id . $c_abb;

?>

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
                    <div class="col-8 mx-auto">
                        <h2><?= $c_name ?> </h2><br>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">ข้อมูลราคาสินค้า </h3>
                                <div class="card-tools">
                                    <a href="price_add.php" class="btn btn-primary">เพิ่มราคาสินค้า</a>
                                </div>

                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-info" style="text-align: center;">
                                            <th width="10%">ลำดับ</th>
                                            <th width="30%">สินค้า</th>
                                            <th width="15%">หน่วยนับ</th>
                                            <th width="15%">ราคาต่อหน่วย</th>
                                            <th width="20%">แก้ไขราคา</th>
                                            <th width="10%">ลบข้อมูล</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // ดึงข้อมูล price detail
                                        $result1 = fetch_pri_detail_dy_pdid($c_id);
                                        if (mysqli_num_rows($result1) > 0) {
                                            $i = 0;
                                            foreach ($result1 as $row) {
                                                $i++;
                                        ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <!-- สินค้า -->
                                                    <td><?= $row['pd_n'] ?></td>
                                                    <input type="hidden" name="pd_id" value="<?= $row['pd_id'] ?>">
                                                    <!-- หน่วยนับ -->
                                                    <td><?= $row['pu_name'] ?></td>
                                                    <!-- ราคาต่อหน่วย -->
                                                    <td><?= $row['pri_sell'] ?></td>
                                                    <!-- ปุ่มแก้ไข -->
                                                    <td>
                                                        <a class="btn btn-block btn-secondary" href="price.php?pri_id=<?= $row['pri_id'] ?>">แก้ไขราคา</a>
                                                    </td>
                                                    <!-- ปุ่มลบข้อมูล -->
                                                    <td>
                                                        <a onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm" href="price_delete.php?pri_id=<?= $row['pri_id'] ?>">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo '<tr><td colspan="6">ไม่พบข้อมูล</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                </form>
                            </div><!-- /.card-body -->
                            <div class="card-footer">
                                <a href="cust.php" class="btn btn-secondary">กลับ</a>
                            </div>
                        </div><!-- /.card -->
                    </div> <!-- /.col -->
                </div><!-- /.row -->
            </div> <!-- /.container-fluid -->
        </section>
    </div> <!-- /.content -->


    <?php
    include('_footer.php');

    ?>