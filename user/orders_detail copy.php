<?php
include("_fn.php");

//GET od_id by fn-save
$od_id = $_GET["od_id"];



//เรียกใช้ function 
$result = fetch_orders_by_id($od_id);

$row = mysqli_fetch_assoc($result);
$c_name = $row['c_name'];
$od_day = $row['od_day'];
$dv_day = $row['dv_day'];
$dv_time = $row['dv_time'];
$od_note = $row['od_note'];
$c_add = $row['c_add'];

//echo $od_id . $c_name . $od_day . $dv_day . $dv_time . $od_note;


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>สั่งซื้อสินค้า</title>
</head>

<body>
  <h3>เลือกสินค้าและกรอกข้อมูลการสั่งซื้อ</h3>

  <!-- ฟอร์มสั่งซื้อสินค้า -->
  <form action="save_order.php" method="post">
    <input type="hidden" name="od_id" value="<?= $_GET['od_id'] ?>">
    <input type="hidden" name="c_id" value="<?= $_GET['c_id'] ?>">

    <!-- เลือกสินค้า -->
    <label for="product">เลือกสินค้า:</label>
    <select name="product_id" id="productSelect" required>
      <option value="">-- เลือกสินค้า --</option>
      <?php
      // ดึงข้อมูลสินค้าจากฐานข้อมูล
      include('database_connection.php');
      $query = "SELECT pd_id, product_name, price, unit FROM products";
      $result = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['pd_id']}' data-price='{$row['price']}' data-unit='{$row['unit']}'>{$row['product_name']}</option>";
      }
      ?>
    </select>

    <!-- แสดงหน่วยนับและราคาต่อหน่วย -->
    <label for="unit">หน่วยนับ:</label>
    <input type="text" name="unit" id="unitDisplay" readonly>

    <label for="price">ราคาต่อหน่วย:</label>
    <input type="text" name="price_sell" id="priceDisplay" readonly>

    <!-- จำนวนสินค้า -->
    <label for="quantity">จำนวน:</label>
    <input type="number" name="quantity" id="quantityInput" min="1" required>

    <!-- เพิ่มรายการสินค้าในตาราง -->
    <button type="button" id="addProductBtn">เพิ่มสินค้า</button>

    <!-- แสดงรายการสินค้า -->
    <table id="productTable" class="table table-bordered table-striped">
      <thead>
        <tr class="table-info">
          <th>ลำดับ</th>
          <th>รายการ</th>
          <th>จำนวน</th>
          <th>หน่วยนับ</th>
          <th>ราคาต่อหน่วย</th>
          <th>รวมเงิน</th>
        </tr>
      </thead>
      <tbody>
        <!-- รายการสินค้า -->
      </tbody>
      <tfoot>
        <tr>
          <th colspan="5" style="text-align:right">ผลรวมทั้งหมด:</th>
          <th id="totalAmount">0.00</th>
        </tr>
      </tfoot>
    </table>

    <!-- ปุ่มบันทึก -->
    <button type="submit">บันทึกข้อมูลทั้งหมด</button>
  </form>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const productSelect = document.getElementById('productSelect');
      const unitDisplay = document.getElementById('unitDisplay');
      const priceDisplay = document.getElementById('priceDisplay');
      const quantityInput = document.getElementById('quantityInput');
      const addProductBtn = document.getElementById('addProductBtn');
      const productTableBody = document.querySelector('#productTable tbody');
      const totalAmountDisplay = document.getElementById('totalAmount');
      let totalAmount = 0;

      productSelect.addEventListener('change', () => {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        unitDisplay.value = selectedOption.dataset.unit || '';
        priceDisplay.value = selectedOption.dataset.price || '';
      });

      addProductBtn.addEventListener('click', () => {
        const productName = productSelect.options[productSelect.selectedIndex].text;
        const price = parseFloat(priceDisplay.value);
        const quantity = parseInt(quantityInput.value);
        const unit = unitDisplay.value;

        if (!isNaN(price) && !isNaN(quantity) && quantity > 0) {
          const subtotal = price * quantity;
          totalAmount += subtotal;
          totalAmountDisplay.textContent = totalAmount.toFixed(2);

          const row = document.createElement('tr');
          row.innerHTML = `
                        <td>${productTableBody.children.length + 1}</td>
                        <td>${productName}</td>
                        <td>${quantity}</td>
                        <td>${unit}</td>
                        <td>${price.toFixed(2)}</td>
                        <td>${subtotal.toFixed(2)}</td>
                    `;
          productTableBody.appendChild(row);

          // เพิ่มข้อมูลในฟอร์มสำหรับส่งไปยัง server
          const form = document.querySelector('form');
          form.innerHTML += `
                        <input type="hidden" name="products[${productTableBody.children.length - 1}][product_id]" value="${productSelect.value}">
                        <input type="hidden" name="products[${productTableBody.children.length - 1}][quantity]" value="${quantity}">
                        <input type="hidden" name="products[${productTableBody.children.length - 1}][price]" value="${price}">
                    `;
        }
      });
    });
  </script>
</body>

</html>


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
                  <h3>จัมโบ้อาหารสด</h3> <br>
                  โทร.081-5304703, 0897000922
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  นามผู้ซื้อ
                  <br>
                  <address>
                    <b><?= $c_name ?></b>
                    <br>
                    <?= $c_add ?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>เลขที่ใบสั่งซื้อ : </b> <a><?= $od_id ?></a>
                  <br>
                  <b>Order days : </b> <a><?= $od_day ?></a>
                  <br>
                  <b>Delivery days : </b> <a><?= $dv_day ?></a>
                  <br>
                  <b>Delivery time :</b> <a><?= $dv_time ?></a>
                  <br>
                  <b>Depatment :</b> <a> <?= $od_note ?></a>
                  <!-- Form รับข้อมูลจำนวนคอรัม -->


                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->


              <div>
                <form id="form1">
                  <div class="form-group">
                    <label for="quantity">จำนวนรายการสินค้า:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="10">
                  </div>
                  <button type="button" class="btn btn-primary" onclick="createTable()">สร้างใบสั่งสินค้า</button>
                </form>
              </div>


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