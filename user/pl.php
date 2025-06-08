<?php
// product list รายการซื้อสินค้า
include('_header.php');
//include('_sidebar_menu.php');
include('_fn.php');



?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Inbox</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Inbox</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">ตลาด / ร้านค้า / รายการ</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="accordion" id="marketAccordion">
            <?php
            // ดึงตลาดทั้งหมด
            $sql_market = "SELECT * FROM market";
            $result_market = mysqli_query($conn, $sql_market);

            while ($market = mysqli_fetch_assoc($result_market)) {
                $mk_id = $market['mk_id'];
            ?>
                <div class="card">
                    <div class="card-header" id="heading<?= $mk_id ?>">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?= $mk_id ?>" aria-expanded="true" aria-controls="collapse<?= $mk_id ?>">
                                <?= htmlspecialchars($market['mk_name']) ?>
                            </button>
                        </h2>
                    </div>

                    <div id="collapse<?= $mk_id ?>" class="collapse" aria-labelledby="heading<?= $mk_id ?>" data-parent="#marketAccordion">
                        <div class="card-body">
                            <ul class="nav flex-column">
                                <?php
                                // ดึงร้านค้าในตลาดนี้
                                $sql_shop = "SELECT s.sp_id, s.sp_name 
                             FROM plan p 
                             JOIN supplier s ON p.sp_id = s.sp_id 
                             WHERE p.mk_id = $mk_id 
                             GROUP BY s.sp_id, s.sp_name";
                                $result_shop = mysqli_query($conn, $sql_shop);

                                while ($shop = mysqli_fetch_assoc($result_shop)) {
                                    $sp_id = $shop['sp_id'];

                                    // นับจำนวนสินค้า
                                    $sql_count = "SELECT COUNT(*) AS total_items 
                                FROM plan 
                                WHERE mk_id = $mk_id AND sp_id = $sp_id";
                                    $count_result = mysqli_query($conn, $sql_count);
                                    $count_data = mysqli_fetch_assoc($count_result);
                                    $total_items = $count_data['total_items'];
                                ?>
                                    <li class="nav-item">
                                        <a href="shop_detail.php?mk_id=<?= $mk_id ?>&sp_id=<?= $sp_id ?>" class="nav-link">
                                            <i class="fas fa-store-alt"></i> <?= htmlspecialchars($shop['sp_name']) ?>
                                            <span class="badge bg-primary float-right"><?= $total_items ?></span>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <a href="compose.html" class="btn btn-primary btn-block mb-3">Compose</a>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Folders</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a href="#" class="nav-link">
                                <i class="fas fa-inbox"></i> Inbox
                                <span class="badge bg-primary float-right">12</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-envelope"></i> Sent
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-file-alt"></i> Drafts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-filter"></i> Junk
                                <span class="badge bg-warning float-right">65</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-trash-alt"></i> Trash
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Labels</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle text-danger"></i>
                                Important
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle text-warning"></i> Promotions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle text-primary"></i>
                                Social
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Inbox</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search Mail">
                            <div class="input-group-append">
                                <div class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="mailbox-controls">
                        <!-- Check all button -->
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fas fa-reply"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fas fa-share"></i>
                            </button>
                        </div>
                        <!-- /.btn-group -->
                        <button type="button" class="btn btn-default btn-sm">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <div class="float-right">
                            1-50/200
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                        <!-- /.float-right -->
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check1">
                                            <label for="check1"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"></td>
                                    <td class="mailbox-date">5 mins ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check2">
                                            <label for="check2"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                    <td class="mailbox-date">28 mins ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check3">
                                            <label for="check3"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                    <td class="mailbox-date">11 hours ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check4">
                                            <label for="check4"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"></td>
                                    <td class="mailbox-date">15 hours ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check5">
                                            <label for="check5"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                    <td class="mailbox-date">Yesterday</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check6">
                                            <label for="check6"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                    <td class="mailbox-date">2 days ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check7">
                                            <label for="check7"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                    <td class="mailbox-date">2 days ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check8">
                                            <label for="check8"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"></td>
                                    <td class="mailbox-date">2 days ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check9">
                                            <label for="check9"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"></td>
                                    <td class="mailbox-date">2 days ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check10">
                                            <label for="check10"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"></td>
                                    <td class="mailbox-date">2 days ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check11">
                                            <label for="check11"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                    <td class="mailbox-date">4 days ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check12">
                                            <label for="check12"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"></td>
                                    <td class="mailbox-date">12 days ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check13">
                                            <label for="check13"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star-o text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                    <td class="mailbox-date">12 days ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check14">
                                            <label for="check14"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                    <td class="mailbox-date">14 days ago</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="icheck-primary">
                                            <input type="checkbox" value="" id="check15">
                                            <label for="check15"></label>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                                    <td class="mailbox-subject"><b>AdminLTE 3.0 Issue</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
                                    <td class="mailbox-date">15 days ago</td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer p-0">
                    <div class="mailbox-controls">
                        <!-- Check all button -->
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                            <i class="far fa-square"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="far fa-trash-alt"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fas fa-reply"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm">
                                <i class="fas fa-share"></i>
                            </button>
                        </div>
                        <!-- /.btn-group -->
                        <button type="button" class="btn btn-default btn-sm">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <div class="float-right">
                            1-50/200
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                        <!-- /.float-right -->
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
</div>

<?php
include('_footer.php');
?>