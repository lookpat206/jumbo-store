<?php
session_start();
require_once '../admin/_fn.php';
require_once '../admin/_fn_db.php';


// Check login
if (!isset($_SESSION["u_id"])) {
  header("Location: ../login/index.php");
  exit;
}

$u_id = $_SESSION["u_id"];
$user = fetch_user_by_uid($u_id);
$row = mysqli_fetch_assoc($user);
$u_name = $row['u_name'];

$total_od = fetch_totalod();
$total_sp = fetch_total_shopping();
$totals_cust = fetch_total_customers();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JumBo-Store</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="register-page">

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- Widget: user widget style 2 -->
          <div class="card card-widget widget-user-2 shadow-sm">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-warning">
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="dist/img/avatar2.png" alt="User Avatar">
              </div>
              <h3 class="widget-user-username"><?= $u_name ?></h3>
            </div>
            <div class="card-footer p-0">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a href="pl.php" class="nav-link">
                    ลูกค้า <span class="float-right badge bg-primary"><?= $totals_cust['total_cust'] ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="po.php" class="nav-link">
                    ตลาด <span class="float-right badge bg-info"><?= $total_sp['total_markets'] ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../login/logout.php" class="nav-link">
                    Logout <span class="float-right badge bg-info"><i class="fas fa-sign-out-alt"></i></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>12</h3>
              <p>รายการซื้อสินค้า</p>
            </div>
            <div class="icon">
              <i class="fas fa-plus-square"></i>
            </div>
            <a href="pl.php" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $total_od ?></h3>
              <p>จำนวนใบสั่งซื้อ</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="orders.php" class="small-box-footer">
              สร้างใบสั่งซื้อ <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>