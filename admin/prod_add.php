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
                        <h3 class="card-title">เพิ่มข้อมูลสินค้า
                        </h3>
                      </div>
                      <form action="prod_add_save.php" method="post">
                      <div class="card-body">
                        <div class="row">
                        <div class="col-md-6"> 
                        <!-- product name -->
                          <div class="form-group">
                            <label for="name">ชื่อสินค้า:</label>
                            <input type="text" name="prod_name" class="form-control"  id="pd" placeholder="ชื่อสินค้า">
                          </div>
                          <div class="form-group">
                            <label for="price">ราคาสินค้า:</label>
                            <input type="number" name="price" min="1" max="1000" step="0.01" class="form-control"  id="pi" placeholder="ราคาสินค้า">
                          </div>
                        </div>
                        <div class="col-md-6">  
                        <div class="form-group">
                            <label for="unit">หน่วยนับสินค้า:</label>
                            <select class="form-control select2" style="width: 100%;">
                              <option selected="selected">กิโลกรัม</option>
                              <option>ขีด</option>
                              <option>ลูก</option>
                              <option>แพ็ค</option>
                              <option>ซอง</option>
                              <option>ถุง</option>
                              <option>ขวด</option>
                              <option>กรัม</option>
                              <option>มัด</option>
                              <option>กระปุก</option>
                              <option>แผ่น</option>
                              <option>หลอด</option>
                              <option>ฟอง</option>
                              <option>ตัว</option>
                              <option>แผง</option>
                              <option>แท่ง</option>
                              <option>กล่อง</option>
                              <option>พับ</option>
                              <option>แกลอน</option>
                            </select>
                        </div>
                        <!-- /.form-group -->
                        
                        
                        <div class="form-group">
                          <label for="type">ประเภทสินค้า:</label>
                          <select class="form-control select2" style="width: 100%;" >
                            <option selected="selected">ผัก</option>
                              <option>ผลไม้</option>
                              <option></option>

                          </select>

                        </div>
                        <div class="form-group">
                          <label for="type">ลูกค้า:</label>
                          <select class="form-control select2" style="width: 100%;" >
                            <option selected="selected">ตูลู่</option>
                              <option>แกรน</option>
                              <option>วีรันดา</option>

                          </select>

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