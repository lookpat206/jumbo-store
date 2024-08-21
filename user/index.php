<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

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

  <section class="contet">
    <div class="conrainer-fluid">
      <div class="row">
        <div class="col-md-12">
          <!-- Widget: user widget style 2 -->
          <div class="card card-widget widget-user-2 shadow-sm">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-warning">
              <div class="widget-user-image">
                <img class="img-circle elevation-2" src="dist/img/avatar2.png" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">ชื่อลูกค้า</h3>

            </div>
            <div class="card-footer p-0">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Projects <span class="float-right badge bg-primary">31</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    Tasks <span class="float-right badge bg-info">5</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../login/logout.php" class="nav-link">
                    logout<span class="float-right badge bg-info"><i class="fas fa-sign-out-alt"></i>
                    </span>

                  </a>
                </li>

              </ul>
            </div>


          </div>
        </div>


        <div class="col-6">
          <!-- small card -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>150</h3>

              <p>Purchase</p>
            </div>
            <div class="icon">
              <i class="fas fa-plus-square"></i>
            </div>
            <a href="purchase.php" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-6">
          <!-- small card -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>150</h3>
              <p>New Orders</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="orders.php" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- ./row -->
    </div>
    </div>


  </section>
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>