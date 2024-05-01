<?php

include ("_fn.php");
// session_start();

// // if($_SESSION['u_status'] <> "Admin"){
// //     header("Location:../login/logout.php");
// // }

// if(isset($_SESSION['u_name'])){
//     $u_name = $_SESSION['u_name'];
// }else {
//     $u_name = "";
// }

// echo "<h1>Administrator</h1>";
// //echo "Hello! " . $u_name;



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางคอรัม</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>ตารางคอรัม</h2>

<form id="form1">
  <label for="quantity">จำนวนคอรัม:</label>
  <input type="number" id="quantity" name="quantity" min="1" max="10">
  <input type="button" value="สร้างตาราง" onclick="createTable()">
</form>

<table id="myTable">
    <thead>
        <tr>
            <th>ลำดับ</th>
            <th>สินค้า</th>
            <th>จำนวน</th>
            <th>หน่วยนับ</th>
            <th>ราคาหน่วยละ</th>
            <th>จำนวนเงิน</th>
        </tr>
    </thead>
    <tbody>
        <!-- ข้อมูลจะถูกเพิ่มที่นี่โดยใช้ JavaScript -->
    </tbody>
</table>

<script>

     var products = ["ไก่", "มาม่า", "ผักกาด", "ปลากระป๋อง"];
     var unit = ["กิโลกรัม","ขีด","ชิ้น","ก้อน"];
   
    function createTable() {
        var quantity = document.getElementById("quantity").value;
        var tableBody = document.querySelector("#myTable tbody");

        // เคลียร์ข้อมูลเก่าในตาราง
        tableBody.innerHTML = "";

       // สร้างแถวใหม่ในตารางตามจำนวนคอรัมที่ระบุ
for (var i = 1; i <= quantity; i++) {
    var row = tableBody.insertRow();
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    cell1.textContent = i;
    
    // สร้าง input และ datalist สำหรับสินค้า
        var inputProduct = document.createElement("input");
        inputProduct.setAttribute("list", "productList" + i);
        inputProduct.name = "product" + i;
        inputProduct.classList.add("form-control");
        cell2.appendChild(inputProduct);

        var datalist = document.createElement("datalist");
        datalist.id = "productList" + i;
        products.forEach(function(product) {
            var option = document.createElement("option");
            option.value = product;
            datalist.appendChild(option);
        });
        cell2.appendChild(datalist)

    // เพิ่มเซลล์ของจำนวนสินค้า
    var inputQuantity = document.createElement("input");
    inputQuantity.type = "number";
    inputQuantity.name = "quantity" + i;
    inputQuantity.classList.add("form-control");
    inputQuantity.addEventListener("input", calculateTotal); // เพิ่ม event listener
    cell3.appendChild(inputQuantity);

    // เพิ่มเซลล์ของหน่วยนับ
    var select2 = document.createElement("select");
    select2.name = "unit" + i; // กำหนดชื่อของ select
    // เพิ่มตัวเลือกสำหรับแต่ละหน่วยนับ
    unit.forEach(function(unit) {
        var option = document.createElement("option");
        option.value = unit;
        option.textContent = unit;
        select2.appendChild(option);
    });
    cell4.appendChild(select2); // เพิ่ม select ลงใน cell

    // เพิ่มเซลล์ของราคาหน่วยละ
    var inputPrice = document.createElement("input");
    inputPrice.type = "number";
    inputPrice.name = "price" + i;
    inputPrice.classList.add("form-control");
    inputPrice.addEventListener("input", calculateTotal); // เพิ่ม event listener
    cell5.appendChild(inputPrice);

    // เพิ่มเซลล์ของจำนวนเงิน (คำนวณจาก ราคา x จำนวน)
    var inputTotal = document.createElement("input");
    inputTotal.type = "text";
    inputTotal.name = "total" + i;
    inputTotal.classList.add("form-control");
    cell6.appendChild(inputTotal);
}
    }

function calculateTotal() {
    var row = this.parentNode.parentNode; // หาแถวที่เป็นพารามิเตอร์ของ input ที่ถูกเปลี่ยนแปลง
    var quantity = parseFloat(row.querySelector('input[name^="quantity"]').value);
    var price = parseFloat(row.querySelector('input[name^="price"]').value);
    var total = isNaN(quantity) || isNaN(price) ? 0 : quantity * price;
    row.querySelector('input[name^="total"]').value = total.toFixed(2); // แสดงผลลัพธ์เป็นทศนิยม 2 ตำแหน่ง
}

    



    function saveData() {
        var quantity = document.getElementById("quantity").value;
        var data = {};

        // เก็บข้อมูลที่ผู้ใช้เลือกในแต่ละคอรัม
        for (var i = 1; i <= quantity; i++) {
            var select = document.querySelector('select[name="product' + i + '"]');
            var selectedProduct = select.options[select.selectedIndex].value;
            data['product' + i] = selectedProduct;
        }

        // ส่งข้อมูลไปยังเซิร์ฟเวอร์ เพื่อบันทึกลงในฐานข้อมูล หรือทำอย่างอื่นต่อไป
        console.log(data); // นี่คือตัวอย่างการแสดงข้อมูลใน console
    }
   
    
    
</script>

</body>
</html>
