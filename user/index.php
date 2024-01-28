<?php 
session_start();

// if($_SESSION['u_status'] <> "Admin"){
//     header("Location:../login/logout.php");
// }

if(isset($_SESSION['u_name'])){
    $u_name = $_SESSION['u_name'];
}else {
    $u_name = "";
}

echo "<h1>User</h1>";
//echo "Hello! " . $u_name;
?>

<!--<!DOCTYPE html>
<html>
<head>
  <title>ระบบสั่งซื้อสินค้า</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h1>ระบบสั่งซื้อสินค้า</h1>
  <form id="order_form">
    <label for="customer_name">ชื่อลูกค้า:</label>
    <input type="text" id="customer_name" name="customer_name" required>
    <br>
    
    <label for="order_number">เลขใบสั่ง:</label>
    <input type="text" id="order_number" name="order_number" required>
    <br>
    
    <table>
      <thead>
        <tr>
          <th>สินค้า</th>
          <th>จำนวน</th>
        </tr>
      </thead>
      <tbody id="product_list">
        <!-- รายการสินค้าจะถูกเพิ่มที่นี่ 
      </tbody>
    </table>
    
    <button type="button" onclick="addProductRow()">เพิ่มสินค้า</button>
    <br>
    
    <input type="submit" value="สั่งซื้อ">
  </form>
  
  <script>
    function addProductRow() {
      const productTable = document.getElementById("product_list");
      const newRow = document.createElement("tr");
      
      const productNameCell = document.createElement("td");
      const productNameInput = document.createElement("input");
      productNameInput.type = "text";
      productNameCell.appendChild(productNameInput);
      
      const quantityCell = document.createElement("td");
      const quantityInput = document.createElement("input");
      quantityInput.type = "number";
      quantityInput.min = 1;
      quantityCell.appendChild(quantityInput);
      
      newRow.appendChild(productNameCell);
      newRow.appendChild(quantityCell);
      
      productTable.appendChild(newRow);
    }
  </script>
</body>
</html>-->


<!DOCTYPE html>
<html>
<head>
  <title>แบบฟอร์มใบสั่งซื้อ</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
    }
    label {
      font-weight: bold;
    }
    input[type="text"], select, input[type="number"] {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: left;
    }
    button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>แบบฟอร์มใบสั่งซื้อ</h1>
    <form action="process_order.php" method="POST">
      <label for="customer_name">ชื่อลูกค้า:</label>
      <input type="text" id="customer_name" name="customer_name" required>
      
      <label for="order_number">เลขใบสั่ง:</label>
      <input type="text" id="order_number" name="order_number" required>
      
      <h2>รายการสินค้า</h2>
      <table>
        <thead>
          <tr>
            <th>สินค้า</th>
            <th>หน่วยนับ</th>
            <th>ราคา (บาท)</th>
            <th>จำนวน</th>
            <th>รวม (บาท)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="text" name="products[]" required></td>
            <td><input type="text" name="units[]" required></td>
            <td><input type="number" name="prices[]" min="0" step="0.01" required></td>
            <td><input type="number" name="quantities[]" min="1" required></td>
            <td><input type="text" name="totals[]" readonly></td>
          </tr>
        </tbody>
      </table>
      
      <button type="submit">สั่งซื้อสินค้า</button>
    </form>
  </div>
</body>
</html>
