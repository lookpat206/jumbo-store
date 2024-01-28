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
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">เพิ่มข้อมูลผู้ใช้ระบบ</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">ข้อมูลผู้ใช้ระบบ</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="user_add_save.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for=" ">Username</label>
                    <input type="text" class="form-control" name="username" id="exampleInputname" placeholder="username">
                  </div>
                  <div class="form-group">
                    <label for=" ">ชื่อผู้ใช้</label>
                    <input type="text" class="form-control" name="u_name" id="exampleInputname" placeholder="ชื่อผู้ใช้">
                  </div>
                  <div class="form-group">
                    
                  <label>สถานะ</label>
                  <select class="form-control select2" style="width: 100%;" name="u_status">
                    <option selected="selected"></option>
                    <option value="ผู้ดูแลระบบ">ผู้ดูแลระบบ</option>
                    <option value="ลูกค้า">ลูกค้า</option>
                    <option value="พนักงาน">พนักงาน</option>
                    
                  </select>
               
                  </div>
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

            
          </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

     <!-- /.row -->
        
  
      
              

        
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            

          
          
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
  