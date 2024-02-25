<?php 
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

//ดึงข้อมูลประเภทจาก TB-p_type
$result = fetch_type();


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
                        <h3 class="card-title">เพิ่มข้อมูลสินค้า</h3>
                      </div>
                      <form action="prod_add_save.php" method="post">
                      <div class="card-body">
                        
                        <!-- product name -->
                          <div class="form-group">
                            <label for="name">ชื่อสินค้า:</label>
                            <input type="text" name="prod_n" class="form-control"  id="pd" placeholder="ชื่อสินค้า">
                          </div>
                        <!-- ประเภทสินค้า -->
                         <div class="form-group">
                          <label for="type">ประเภทสินค้า:</label>
                          <select class="form-control select2" style="width: 100%;" >
                            <option selected="selected" value="">-- เลือกข้อมูล --</option>
                              <?php foreach($result as $row){ ?>
                              <option value="<?=$row['pt_id']?>" > <?= $row['pt_name']?> </option>
                              <?php } ?>

                          </select>

                        </div>

                          <!-- จำนวนสินค้า -->
                          <div class="form-group">
                              <label for="prod-quantity">จำนวนสินค้า</label>
                              <input type="number" name="prod_q" class="form-control" value="0" step="0.01" min="0" max="999" placeholder="ปริมาณสินค้าคงเหลือ">
                          </div>
                          
                          <!-- รายละเอียดสินค้า -->
                          <div class="form-group">
                            <label for="prod-fuature">รายละเอียดสินค้า</label>
                            <textarea class="form-control" name="prod_f" id="prod-fuature" rows="3" placeholder="รายละเอียดสินค้า" ></textarea>
                          </div>
                          <!-- รูปสินค้า -->
                          <div class="form-group">
                            <label for="exampleInputFile">ภาพสินค้า</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" name="prod_i" id="exampleInputFile" >
                                <label class="custom-file-label" for="exampleInputFile">Choose file ขนาดไม่เกิน 5 MB</label>
                              </div>
                              
                            </div>
                          </div>
                        
                      </div> <!-- /.card-body -->

                      <!-- บันทึก -->
                      <div class="card-footer">
                        <button type="submit" class="btn btn-danger">บันทึก</button>
                        <a href="prod.php" class="btn btn-secondary">กลับ</a>
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