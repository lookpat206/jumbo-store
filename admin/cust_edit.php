<?php 
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('_fn.php');

 $c_id=$_GET['c_id'];

    $result = fetch_cust_by_cid($c_id);
    $row = mysqli_fetch_assoc($result);
    $c_name = $row['c_name'];
    $c_add = $row['c_add'];
    $c_tel = $row['c_tel'];
    $c_abb = $row['c_abb'];

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ข้อมูลลูกค้า</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                      <div class="card-header">
                        <h3 class="card-title">แก้ไขข้อมูลลูกค้า</h3>
                      </div>
                      <form action="cust_edit_save.php" method="POSt">
                        <input type="hidden" name="c_id" value="<?=$c_id?>">
                      <div class="card-body">
                        <!--name cust -->
                          <div class="form-group">
                            <label for="name">ชื่อลูกค้า:</label>
                            <input value="<?=$c_name?>" type="text" name="c_name" class="form-control"  id="name" placeholder="ชื่อโรงแรม/ชื่อบริษัท">
                          </div>
                        <!-- address cust -->
                          <div class="form-group">
                            <label for="address">ที่อยู่: </label>
                            <input value="<?=$c_add?>" type="text" name="c_add" class="form-control" id="address" placeholder="เลขที่/หมู่/ซอย/ตำบล/อำเภอ/จังหวัด/รหัสไปรษณี">
                          </div>
                        <!-- phone mask -->
                          <div class="form-group">
                            <label>เบอร์โทรศัพท์:</label>

                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                              </div>
                                <input value="<?=$c_tel?>" type="text" name="c_tel" class="form-control" data-inputmask="'mask': '999-999-9999'" data-mask=" " type="text">
                            </div>
                            <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                        <!-- อักษรย่อชื่อ cust -->
                            <div class="form-group">
                              <label for="abbreviation">ชื่อย่อ: </label>
                              <input value="<?=$c_abb?>" type="text" name="c_abb" class="form-control" id="abbreviation" placeholder="อักษรย่อชื่อลูกค้า">
                            </div>
                        
                      </div> <!-- /.card-body -->

                      <!-- บันทึก -->
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
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