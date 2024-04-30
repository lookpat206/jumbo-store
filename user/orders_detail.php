<?php 


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Invoice</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
   <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper Content">
  <div class="Content">
    <div class="content-header">

    </div>
  </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-10 mx-auto">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                     ใบสั่งสินค้าชั่วคราว 
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!--  ชื่อร้าน -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <strong>จัมโบ้อาหารสด</strong>  <br>
                  โทร.081-5304703, 0897000922
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  นามผู้ซื้อ
                  <address>
                    
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>เลขที่ใบสั่ง #007612</b><br>
                  <br>
                  <b>Order days:</b> 4F3S8J<br>
                  <b>Delivery days:</b> 2/22/2014<br>
                  <b>Depatment:</b> 968-34567
                  <!-- Form รับข้อมูลจำนวนคอรัม -->
  <form id="form1">
    <div class="form-group">
      <label for="quantity">จำนวนรายการสินค้า:</label>
      <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="10">
    </div>
    <button type="button" class="btn btn-primary" onclick="createTable()">สร้างใบสั่งสินค้า</button>
  </form>

                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- ตารางใบสั่งสินค้า -->
  <div id="invoiceTable"></div>
</div>
             

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                  <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                  </button>
                  <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                  </button>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer no-print">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
  function createTable() {
    var quantity = parseInt(document.getElementById("quantity").value);
    var table = '<table class="table table-striped"><thead><tr><th>ลำดับ</th><th>รายการสินค้า</th><th>จำนวน</th><th>หน่วยนับ</th><th>ราคาต่อหน่วย</th><th>จำนวนเงิน</th></tr></thead><tbody>';
    
    // เพิ่มแถวในตารางตามจำนวนคอรัมที่ระบุ
    for (var i = 1; i <= quantity; i++) {
      table += '<tr>';
      table += '<td>' + i + '</td>';
      table += '<td><input type="text" class="form-control" name="product[]" placeholder="รายการสินค้า"></td>';
      table += '<td><input type="text" class="form-control" name= "num[]"></td>';
      table += '<td><input type="text" class="form-control" name="unit[]" placeholder="หน่วยละ"></td>';
      table += '<td><input type="text" class="form-control" name="unit_price[]"></td>';
      table += '<td><input type="text" class="form-control" name="total[]"></td>';
      table += '</tr>';
    }
    
    table += '</tbody></table>';
    
    // แทรกตารางใบสั่งสินค้าลงใน div
    document.getElementById("invoiceTable").innerHTML = table;
  }
</script>


</body>
</html>
