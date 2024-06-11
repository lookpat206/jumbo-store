<?php
// ติดปัญหาบันทึกข้อมูล
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

// GET c_id by cust.php
$c_id = $_GET['c_id'];


//ดึงข้อมูล หน่วยนับ 
$result2 = fetch_unit();

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
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">ข้อมูลราคาขายสินค้า <?= $c_name ?> </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="price_save.php">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="table-info">
                                                <th width="10%">ลำดับ</th>
                                                <th width="50%">สินค้า</th>

                                                <th width="20%">เพิ่มราคาสินค้า</th>
                                                <th width="20%">แก้ไขราคาสินค้า</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $result1 = fetch_prod();
                                            if (mysqli_num_rows($result1) > 0) {
                                                $i = 0;
                                                foreach ($result1 as $row) {
                                                    $i++;
                                            ?>
                                                    <tr>
                                                        <td><?= $i ?></td>

                                                        <td><?= $row['pd_n'] ?></td>
                                                        <input type="hidden" name="pd_id" value="<?= $row['pd_id'] ?>">

                                                        <td>
                                                            <a type="button" class="btn btn-block btn-primary" href="price_add.php?c_id=<?= htmlspecialchars($c_id) ?>&pd_id=<?= htmlspecialchars($row['pd_id']) ?>">เพิ่ม</a>
                                                        </td>

                                                        <td>
                                                            <a class="btn btn-block btn-secondary" href="price.php?c_id=<?= $row['c_id'] ?>">แก้ไขราคา</a>
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