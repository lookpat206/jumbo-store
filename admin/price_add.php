<?php 
include('_header.php');
//include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

$prod_id=$_GET['prod_id'];//รับ id จาก prod.php

//ดึงข้อมูล id จาก TB-product
$result = fetch_product_by_prodid($prod_id);
    $row = mysqli_fetch_assoc($result);
    $prod_n = $row['prod_n'];

//ดึงข้อมูล จาก TB-unit    
$result1 = fetch_unit();
//ดึงข้อมูลลูกค้า จาก TB-cust
$result2 = fetch_cust() ;
   

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
                        <h3 class="card-title">เพิ่มราคาสินค้า</h3>
                      </div>
                      <form action="price_add_save.php" method="post">
                        <input type="hidden" name="prod_id" value="<?=$prod_id?>">
                      <div class="card-body">
                       
                          <!-- product name -->
                          <div class="form-group">
                            <label for=" ">ชื่อสินค้า</label>
                            <input disabled value="<?=$prod_n?>" type="text" class="form-control" name="username" id="exampleInputname" >
                          </div>
                      
                        <!-- unit -->
                        <div class="form-group">
                            <label for="unit">หน่วยนับสินค้า:</label>
                            <select class="form-control select2" name="pu_id" style="width: 100%;">
                              <option selected="selected" value="">-- เลือกข้อมูล --</option>
                              <?php foreach($result1 as $row){ ?>
                              <option value="<?=$row['pu_id']?>" > <?= $row['pu_name']?> </option>
                              <?php } ?>

                             </select>
                        </div>
                <!-- /.form-group -->
                        <!-- price -->
                         <div class="form-group">
                            <label for="price">ราคาสินค้า</label>
                            <div class="input-group">
                              <input type="number" name="price" class="form-control" value="0" step="0.01" min="0" max="999" placeholder="ราคาสินค้า">
                              <div class="input-group-append">
                                <span class="input-group-text">บาท</span>
                              </div>
                            </div>
                        </div>

                       

                      <!-- customer -->
                        <div class="form-group">
                            <label for="cust">ลูกค้า:</label>
                            <select class="form-control select2" name="c_id" style="width: 100%;">
                              <option selected="selected" value="">-- เลือกข้อมูล --</option>
                              <?php foreach($result2 as $row){ ?>
                              <option value="<?=$row['c_id']?>" > <?= $row['c_abb']?> </option>
                              <?php } ?>

                             </select>
                         
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