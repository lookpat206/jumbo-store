<?php 
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

$result1 = fetch_type() ;
$result2 = fetch_mark();

//รับ id-supplied by supplier.php
$sp_id = $_GET['sp_id'];
//ส่ง ค่าid-supplied  ไปดึงข้อมูล supplier
$result3 = fetch_supp_by_spid($sp_id);
$row = mysqli_fetch_assoc($result1);
$sp_name = $row['sp_name'];
$sp_tel = $row['sp_tel'];

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
                        <h3 class="card-title">แก้ไขข้อมูลร้านค้า</h3>
                      </div>
                      <form action="supp_add_save.php" method="post">
                         <input type="hidden" name="sp_id" value="<?=$sp_id?>">
                      <div class="card-body">
                        <!--name cust -->
                          <div class="form-group">
                            <label for="name">ชื่อร้นค้า:</label>
                            <input type="text" name="sp_name" class="form-control"  id="name" placeholder="ชื่อร้านค้า">
                          </div>
                      
                          <!-- ประเภทสินค้า -->
                         <div class="form-group">
                          <label for="type">ประเภทสินค้า:</label>
                          <select class="form-control select2" name="pt_id" style="width: 100%;" >
                            <option selected="selected" value="">-- เลือกข้อมูล --</option>
                              <?php foreach($result1 as $row){ ?>
                              <option value="<?=$row['pt_id']?>" > <?= $row['pt_name']?> </option>
                              <?php } ?>

                          </select>

                        </div>
                        
                        <!-- ที่อยู่ร้านค้า -->
                         <div class="form-group">
                          <label for="type">สถานที่ซื้อสินค้า:</label>
                          <select class="form-control select2" name="mk_id" style="width: 100%;" >
                            <option selected="selected" value="">-- เลือกข้อมูล --</option>
                              <?php foreach($result2 as $row){ ?>
                              <option value="<?=$row['mk_id']?>" > <?= $row['mk_name']?> </option>
                              <?php } ?>

                          </select>

                        </div><!-- /.form group -->

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
                        <a href="supplier.php" class="btn btn-secondary">กลับ</a>
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