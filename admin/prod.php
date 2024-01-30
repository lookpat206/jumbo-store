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
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ข้อมูลสินค้า</h1>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ตารางข้อมูลสินค้า</h3>
                            <div class="card-tools">
                                <a href="prod_add.php" class="btn btn-primary" >เพิ่มข้อมูลสินค้า</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                    
                            <thead>
                                <tr>
                                    <th style="width: 10%;">ลำดับ</th>
                                    <th style="width: 70%;">ชื่อสินค้า</th>
                                    <th style="width: 10%;">แก้ไข</th>
                                    <th style="width: 10%;">ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                $i=0;
                                $result = fetch_prod();
                                if (mysqli_num_rows($result) >0) {

                                  while($row = mysqli_fetch_assoc($result)){
                                    $i++;
                                    echo "<tr>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['prod_name'] . "</td>";
                                    
                                    
                                    echo "<td>";
                                echo '<a  class="btn btn-default btn-sm" style="color: orange" href="prod_edit.php?c_id='.$row['prod_id'].'">';
                                echo '<i class="far fa-edit" ></i>';
                                echo '</a>';
                                echo "</td>";
                                echo "<td>";
                                echo '<a onClick="return confirm(\'Are you sure you want to delete?\')" class="btn btn-default btn-sm" href="prod_delete.php?c_id='.$row['prod_id'].'">';
                                echo '<i class="far fa-trash-alt" style="color: red"></i>';
                                echo '</a>';
                                echo "</td>";
                                    
                                    

                                    echo "</tr>";
                                  }
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