<?php
session_start();

include('_fn.php');
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');



// if(isset($_SESSION['msg_err'])) {
//   $msg_err = $_SESSION['msg_err'];
// } else {
//   $msg_err = "";
// }
?>



<!-- Content Wrapper. Contains page content -->
<section class="content">
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">ผู้ใช้ระบบ</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">ข้อมูลผู้ใช้ระบบ</h3>
                <div class="card-tools">
                  <a href="user_add.php" class="btn btn-primary">เพิ่มข้อมูล</a>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10%;">ลำดับ</th>
                      <th style="width: 50%;">ชื่อผู้ใช้</th>
                      <th style="width: 20%;">หน้าที่</th>
                      <th style="width: 10%;">แก้ไข</th>
                      <th style="width: 10%;">ลบ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    $result = fetch_user();
                    if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $i++;
                        echo "<tr>";
                        echo "<td>{$i}</td>";
                        echo "<td>{$row['u_name']}</td>";
                        echo "<td>{$row['u_status']}</td>";
                        echo "<td><a class='btn btn-default btn-sm' href='user_edit.php?u_id={$row['u_id']}'><i class='far fa-edit'></i></a></td>";
                        echo "<td><a onclick=\"return confirm('Are you sure you want to delete?')\" class='btn btn-default btn-sm' href='user_delete.php?u_id={$row['u_id']}'><i class='far fa-trash-alt'></i></a></td>";
                        echo "</tr>";
                      }
                    } else {
                      echo "<tr><td colspan='5' class='text-center'>ไม่มีข้อมูลผู้ใช้</td></tr>";
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

</section>
<!-- /.Left col -->
<!-- right col (We are only adding the ID to make the widgets sortable)-->
<section class="col-lg-5 connectedSortable">




</section>
<!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('_footer.php');

?>