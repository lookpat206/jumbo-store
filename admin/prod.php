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
      <h3 class="text display-4">รายการซื้อสินค้า</h3>

      <div class="row">

        <div class="col-6 mx-auto"">
          
          <div class=" card card-primary">
          <div class="card-header">
            <h4 class="card-title">เพิ่มชื่อสินค้า</h4>
          </div>
          <form action="prod_save.php" method="post">
            <div class="card-body">

              <div class="form-group">
                <input type="text" name="pd_n" class="form-control" placeholder="ชื่อสินค้า">
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">เพิ่มสินค้า</button>

            </div>
          </form>
        </div>

      </div>
      <div class="col-6 mx-auto">
        <div class="card card-widget">

          <div class="widget-user-header bg-green " style=" text-align: center">
            <div class="inner">
              <h5></h5>
              <h1><?php echo date('d-m-Y');  ?></h1>

            </div>

          </div>
          <div class=" card-footer p-0">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link">
                  จำนวสินค้าเข้า<span class="float-right badge bg-secondary"></span>
                </a>


              </li>
              <li class="nav-item">
                <a class="nav-link">
                  จำนวนสินค้าออก <span class="float-right badge bg-secondary"></span>
                  <br>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link">
                  จำนวนสินค้าคงเหลือ <span class="float-right badge bg-secondary"></span>
                  <br>
                </a>
              </li>

            </ul>
          </div>
        </div>
        <!-- /.col -->
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
            <h3 class="card-title">ตารางข้อมูลสินค้า</h3>
            <div class="card-tools">

            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">

              <thead>
                <tr>
                  <th style="width: 10%;">ลำดับ</th>
                  <th style="width: 30%;">ชื่อสินค้า</th>
                  <th style="width: 20%">จำนวนสินค้า</th>
                  <th style="width: 20%;">แก้ไข</th>
                  <th style="width: 20%;">ลบ</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $result = fetch_prod();
                if (mysqli_num_rows($result) > 0) {
                  $i = 0;
                  foreach ($result as $row) {
                    $i++;
                ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $row['pd_n'] ?></td>
                      <td>

                      <td>
                        <a class="btn btn-warning btn-sm" href="prod_edit.php?pd_id=<?= $row['pd_id'] ?>">
                          <i class="far fa-edit"></i>
                        </a>
                      </td>
                      <td>
                        <a onClick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm" href="prod_delete.php?pd_id=<?= $row['pd_id'] ?>">
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