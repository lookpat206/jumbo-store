<?php
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

$result1 = fetch_type();
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
            <form action="supp_add_save.php" method="post">
              <div class="card-body">

                <!--name ร้านค้า -->
                <div class="form-group">
                  <label for="name">ชื่อร้านค้า:</label>
                  <input type="text" name="sp_name" class="form-control" id="name" placeholder="ชื่อร้านค้า">
                </div>

                <!-- ประเภทสินค้า -->
                <div class="form-group">
                  <label for="type">ประเภทสินค้า:</label>
                  <select class="form-control select2" name="pt_id" style="width: 100%;">
                    <option selected="selected" value="">-- เลือกข้อมูล --</option>
                    <?php foreach ($result1 as $row) { ?>
                      <option value="<?= $row['pt_id'] ?>"> <?= $row['pt_name'] ?> </option>
                    <?php } ?>

                  </select>

                </div>

                <!-- phone mask -->
                <div class="form-group">
                  <label>เบอร์โทรศัพท์:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                    </div>
                    <input type="text" name="sp_tel" class="form-control" data-inputmask="'mask': '999-999-9999'" data-mask=" " type="text">
                  </div><!-- /.input group -->

                </div><!-- /.form group -->


              </div> <!-- /.card-body -->

              <!-- บันทึก -->
              <div class="card-footer">
                <button type="submit" class="btn btn-danger">บันทึก</button>
                <a href="supp.php" class="btn btn-secondary">กลับ</a>
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