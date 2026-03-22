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
//print_r($u_id); // แสดงค่า u_id สำหรับดีบัก

// if (isset($_SESSION['msg'])) {
//     echo '<div class="alert alert-info">' . $_SESSION['msg'] . '</div>';
//     unset($_SESSION['msg']);
// }


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
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo htmlspecialchars($row['mk_name']); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body collapse show"> <!-- show ให้เปิดโดย default -->
                                <table id="table_<?php echo $row['mk_id']; ?>" class="table table-bordered table-striped data-table">
                                    <thead>
                                        <tr class="table-info">
                                            <th width="7%" class="text-center">ซื้อได้</th>
                                            <th width="20%">ร้านค้า</th>
                                            <th width="20%">สินค้า</th>
                                            <th width="5%">หน่วย</th>
                                            <th width="10%">จำนวน</th>
                                            <th width="10%">ราคา</th>
                                            <th width="10%">รวมเงิน</th>

                                            <th width="8%">ซื้อไม่ได้</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        $result2 = get_market_details($row['mk_id'], $u_id);
                                        $sum_total = 0;

                                        while ($item = mysqli_fetch_assoc($result2)):

                                            $sum_total += $item['total_price'];

                                        ?>

                                            <tr
                                                data-plan="<?= $item['plan_id'] ?>"
                                                data-mk="<?= $row['mk_id'] ?>"
                                                data-sp="<?= $item['sp_id'] ?>"
                                                data-pd="<?= $item['pd_id'] ?>"
                                                data-pu="<?= $item['pu_id'] ?>">

                                                <td class="text-center">

                                                    <input type="checkbox"
                                                        class="chk-buy"

                                                        data-plan="<?= $item['plan_id'] ?>"
                                                        data-mk="<?= $row['mk_id'] ?>"
                                                        data-sp="<?= $item['sp_id'] ?>"
                                                        data-pd="<?= $item['pd_id'] ?>"
                                                        data-pu="<?= $item['pu_id'] ?>"

                                                        <?= ($item['syn_stock'] == 1) ? 'checked disabled' : '' ?>>


                                                </td>


                                                <td><?= htmlspecialchars($item['sp_name']) ?></td>

                                                <td><?= htmlspecialchars($item['pd_n']) ?></td>

                                                <td><?= htmlspecialchars($item['pu_name']) ?></td>

                                                <td>

                                                    <input
                                                        type="number"
                                                        class="form-control qty-input"
                                                        step="0.01"
                                                        value="<?= $item['quantity'] ?>">

                                                </td>

                                                <td>

                                                    <input
                                                        type="number"
                                                        class="form-control price-input"
                                                        step="0.01"
                                                        value="<?= $item['sp_price'] ?>">

                                                </td>

                                                <td class="total-cell">

                                                    <?= number_format($item['total_price'], 2) ?>

                                                </td>



                                                <td>

                                                    <a class="btn btn-warning btn-sm"
                                                        href="pl_edit_status.php?pd_id=<?= $item['pd_id'] ?>&sp_id=<?= $item['sp_id'] ?>">

                                                        <i class="far fa-edit"></i>

                                                    </a>

                                                </td>

                                            </tr>

                                        <?php endwhile ?>

                                    </tbody>

                                    <tfoot>

                                        <tr class="table-secondary">

                                            <td colspan="6" class="text-center">

                                                <strong>รวมเงิน</strong>

                                            </td>

                                            <td colspan="3">

                                                <span class="sum-footer">

                                                    <?= number_format($sum_total, 2) ?>

                                                </span> บาท

                                            </td>

                                        </tr>

                                    </tfoot>


                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- /.content -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        function calcRow(row) {

            let qty = parseFloat(row.querySelector(".qty-input").value) || 0
            let price = parseFloat(row.querySelector(".price-input").value) || 0

            let total = qty * price

            row.querySelector(".total-cell").innerText =
                total.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                })

        }

        document.querySelectorAll(".qty-input,.price-input")
            .forEach(el => {

                el.addEventListener("input", function() {

                    let row = this.closest("tr")

                    calcRow(row)

                })

            })

        /* BUY */

        document.querySelectorAll(".chk-buy")
            .forEach(chk => {

                chk.addEventListener("change", function() {

                    if (!this.checked) return

                    let row = this.closest("tr")

                    let data = {
                        plan_id: this.dataset.plan,
                        mk_id: this.dataset.mk,
                        sp_id: this.dataset.sp,
                        pd_id: this.dataset.pd,
                        pu_id: this.dataset.pu,

                        qty: row.querySelector(".qty-input").value,
                        price: row.querySelector(".price-input").value

                    }

                    if (data.qty <= 0 || data.price <= 0) {

                        alert("กรุณากรอกจำนวนและราคา")
                        this.checked = false
                        return

                    }

                    fetch("pl_ajax_save_purchase.php", {

                            method: "POST",

                            headers: {
                                "Content-Type": "application/json"
                            },

                            body: JSON.stringify(data)

                        })

                        .then(async response => {

                            let text = await response.text()

                            console.log("RAW RESPONSE:", text)

                            try {
                                return JSON.parse(text)
                            } catch (e) {
                                throw new Error("JSON PARSE ERROR")
                            }

                        })

                        .then(res => {

                            console.log(res)

                            if (res.status === "success") {

                                row.style.background = "#d4edda"
                                this.disabled = true

                            } else {

                                alert(res.message || "บันทึกไม่สำเร็จ")
                                this.checked = false

                            }

                        })

                        .catch(err => {

                            console.error(err)

                            alert("AJAX ERROR : " + err)

                            this.checked = false

                        })
                })

            })

    })
</script>
<?php


include('_footer.php');
?>