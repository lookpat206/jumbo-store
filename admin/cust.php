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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ข้อมูลลูกค้า</h3>
                            <div class="card-tools">
                                <a href="cust_add.php" class="btn btn-primary" >เพิ่มข้อมูลลูกค้า</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                    
                            <thead>
                                <tr>
                                    <th >ลำดับ</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>ที่อยู่</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>อักษรย่อ</th>
                                    <th>แก้ไข</th>
                                    <th>ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                $i=0;
                                $result = fetch_cust();
                                if (mysqli_num_rows($result) >0) {

                                  while($row = mysqli_fetch_assoc($result)){
                                    $i++;
                                    echo "<tr>";
                                    echo "<td>" . $i . "</td>";
                                    echo "<td>" . $row['c_name'] . "</td>";
                                    echo "<td>" . $row['c_add'] . "</td>";
                                    echo "<td>" . $row['c_tel'] . "</td>";
                                    echo "<td>" . $row['c_abb']."</td>";
                                    echo "<td>";
                                echo '<a  class="btn btn-default btn-sm" href="cust_edit.php?c_id='.$row['c_id'].'">';
                                echo '<i class="far fa-edit"></i>';
                                echo '</a>';
                                echo "</td>";
                                echo "<td>";
                                echo '<a onClick="return confirm(\'Are you sure you want to delete?\')" class="btn btn-default btn-sm" href="cust_delete.php?c_id='.$row['c_id'].'">';
                                echo '<i class="far fa-trash-alt"></i>';
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