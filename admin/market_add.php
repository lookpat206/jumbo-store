<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');


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
                            <h3 class="card-title">เพิ่มข้อมูลร้านค้า</h3>
                        </div>
                        <form action="market_add_save.php" method="post">
                            <div class="card-body">

                                <!--name ร้านค้า -->
                                <div class="form-group">
                                    <label for="name">ชื่อสถานที่ซื้อสินค้า:</label>
                                    <input type="text" name="mk_name" class="form-control" id="name" placeholder="ชื่อร้านค้า">
                                </div>




                            </div> <!-- /.card-body -->

                            <!-- บันทึก -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger">บันทึก</button>
                                <a href="market.php" class="btn btn-secondary">กลับ</a>
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