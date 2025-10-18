<?php

//สรุปรายการซื้อสินค้า user/pl.php

session_start();
// product list รายการซื้อสินค้า
include('_header.php');
include('_navbar.php');
include('_sidebar_menu.php');
include('_fn.php');
include('../admin/_fn_db.php');

// ตรวจสอบว่ามีการ login แล้วหรือไม่ และ u_id ถูกเก็บไว้ใน session หรือไม่
if (!isset($_SESSION['u_id'])) {
    header("Location: login.php");
    exit;
}

$u_id = isset($_SESSION['u_id']) ? intval($_SESSION['u_id']) : 0;
print_r($u_id); // แสดงค่า u_id สำหรับดีบัก



// ดึงข้อมูลตลาดที่ซื้อสินค้า
$result = fetch_market_byuid($u_id);




?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>สรุปรายการซื้อสินค้า</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($result as $row): ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo htmlspecialchars($row['mk_name']); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-target="#market<?php echo $row['mk_id']; ?>">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Body: collapse -->
                            <div class="card-body collapse" id="market<?php echo $row['mk_id']; ?>">

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="table-info">
                                            <th width="5%">ซื้อสำเร็จ</th>
                                            <th width="20%">ร้านค้า</th>
                                            <th width="20%">สินค้า</th>
                                            <th Width="10%">หน่วย</th>
                                            <th width="10%">จำนวน</th>
                                            <th width="10%">ราคา</th>
                                            <th width="10%">รวมเงิน</th>

                                            <th width="15%">แก้ไขบิล</th>
                                            <th width="5%">หมายเหตุ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result2 = get_market_details($row['mk_id'], $u_id);
                                        $sum_total = 0;
                                        while ($row = mysqli_fetch_assoc($result2)):
                                            $sum_total += $row['total_price'];
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input
                                                            class="form-check-input status-checkbox"
                                                            type="checkbox"
                                                            data-pd-id="<?php echo $row['pd_id']; ?>"
                                                            <?php echo ($row['sp_status'] == 'ซื้อแล้ว') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label status-label">
                                                            <?php echo ($row['sp_status'] == 'ซื้อแล้ว') ? 'ซื้อแล้ว' : 'ยังไม่ได้ซื้อ'; ?>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['sp_name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['pd_n']); ?></td>
                                                <td data-unit-id="<?php echo $row['pu_id']; ?>">
                                                    <?php echo htmlspecialchars($row['pu_name']); ?>
                                                </td>
                                                <!-- quantity editable -->
                                                <td>
                                                    <input type="number" class="form-control quantity-input" min="0" step="0.01"
                                                        data-pd-id="<?php echo $row['pd_id']; ?>"
                                                        value="<?php echo number_format($row['quantity'], 2); ?>">
                                                </td>

                                                <!-- sp_price editable -->
                                                <td>
                                                    <input type="number" class="form-control price-input" min="0" step="0.01"
                                                        data-pd-id="<?php echo $row['pd_id']; ?>"
                                                        value="<?php echo number_format($row['sp_price'], 2); ?>">
                                                </td>
                                                <td class="total-price" data-pd-id="<?php echo $row['pd_id']; ?>">
                                                    <?php echo number_format($row['total_price'], 2); ?>
                                                </td>

                                                <td>
                                                    <a class="btn btn-danger btn-sm" href="pl_edit_po.php?pd_id=<?= $row['pd_id'] ?>">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning btn-sm" href="pl_edit_status.php?pd_id=<?= $row['pd_id'] ?>">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                </td>
                                            <?php endwhile; ?>
                                            <tr class="total-row">
                                                <td colspan="6">รวมเงิน</td>
                                                <td colspan="3"><?php echo number_format($sum_total, 2); ?> บาท</td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer">

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<?php
// JavaScript สำหรับจัดการการเปลี่ยนแปลงจำนวนและราคาสินค้า
?>
<script>
    $(document).ready(function() {
        function updateTotal(pd_id) {
            var quantity = parseFloat($(`.quantity-input[data-pd-id='${pd_id}']`).val()) || 0;
            var price = parseFloat($(`.price-input[data-pd-id='${pd_id}']`).val()) || 0;
            var total = quantity * price;
            $(`.total-price[data-pd-id='${pd_id}']`).text(total.toFixed(2));
        }

        $('.quantity-input').on('change', function() {
            var pd_id = $(this).data('pd-id');
            var quantity = $(this).val();
            updateTotal(pd_id);

            $.post('update_price_quantity.php', {
                pd_id: pd_id,
                quantity: quantity
            }, function(response) {
                if (response.trim() != "success") {
                    alert("อัพเดตจำนวนไม่สำเร็จ");
                }
            });
        });

        $('.price-input').on('change', function() {
            var pd_id = $(this).data('pd-id');
            var price = $(this).val();
            updateTotal(pd_id);

            $.post('update_price_quantity.php', {
                pd_id: pd_id,
                sp_price: price
            }, function(response) {
                if (response.trim() != "success") {
                    alert("อัพเดตราคาไม่สำเร็จ");
                }
            });
        });
    });
    // เมื่อคลิก checkbox “ซื้อสำเร็จ”
    $('.status-checkbox').on('change', function() {
        var checkbox = $(this);
        var pd_id = checkbox.data('pd-id');

        // ดึงข้อมูลจาก input เดียวกันในแถว
        var row = checkbox.closest('tr');
        var quantity = parseFloat(row.find('.quantity-input').val()) || 0;
        var unit_price = parseFloat(row.find('.price-input').val()) || 0;
        var unit_id = row.data('unit-id') || 0;
        var sp_id = <?php echo isset($row['sp_id']) ? $row['sp_id'] : '0'; ?>;

        if (checkbox.is(':checked')) {
            if (confirm("ยืนยันว่าซื้อสินค้านี้สำเร็จแล้วใช่ไหม?")) {
                $.post('pl_update.php', {
                    pd_id: pd_id,
                    sp_id: sp_id,
                    quantity: quantity,
                    unit_price: unit_price,
                    unit_id: unit_id
                }, function(response) {
                    if (response.trim() === "success") {
                        alert("บันทึกข้อมูลเรียบร้อยแล้ว");
                        checkbox.next('.status-label').text('ซื้อแล้ว');
                        row.find('.quantity-input, .price-input').prop('disabled', true);
                    } else {
                        alert("เกิดข้อผิดพลาดในการบันทึก");
                        checkbox.prop('checked', false);
                    }
                });
            } else {
                checkbox.prop('checked', false);
            }
        }
    });
</script>
<?php
include('_footer.php');
?>