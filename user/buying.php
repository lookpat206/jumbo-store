<?php
include('_header.php');
include('_navbar.php');
//include('_sidebar_menu.php');
include('_fn.php');

?>
<?php


// ดึงข้อมูลรายการสินค้า พร้อมชื่อร้าน (market) // ใช้ ? เพื่อป้องกัน SQL Injection
$sql = "SELECT sp.pl_id, p.pd_n, sp.quantity, sp.sp_price, m.mk_id, m.mk_name
        FROM sp_list AS sp
        JOIN market AS m ON sp.mk_id = m.mk_id
        JOIN product AS p ON sp.pd_id = p.pd_id
        WHERE sp.u_id = 8 
        ORDER BY m.mk_id, sp.pl_id";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

// สร้างอาร์เรย์เก็บข้อมูลแยกร้าน
$shops = [];
while ($row = mysqli_fetch_assoc($result)) {
    $mk_id = $row['mk_id'];
    if (!isset($shops[$mk_id])) {
        $shops[$mk_id] = [
            'name' => $row['mk_name'],
            'products' => []
        ];
    }
    $shops[$mk_id]['products'][] = $row;
}
?>

<!-- Bootstrap Tab HTML -->
<div class="col-md-9">
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <?php
                $active = "active";
                foreach ($shops as $mk_id => $shop) {
                    // ใช้ id tab เป็น shop{mk_id}
                    echo "<li class='nav-item'>";
                    echo "<a class='nav-link $active' href='#shop{$mk_id}' data-toggle='tab'>{$shop['name']}</a>";
                    echo "</li>";
                    $active = ""; // แค่ tab แรก active
                }
                ?>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <?php
                $active = "show active";
                foreach ($shops as $mk_id => $shop) {
                    echo "<div class='tab-pane fade $active' id='shop{$mk_id}'>";
                    echo "<table class='table table-bordered table-striped'>";
                    echo "<thead><tr class='table-info'>
                            <th>ลำดับ</th>
                            <th>ชื่อสินค้า</th>
                            <th>จำนวน</th>
                            <th>ราคา</th>
                            <th>แก้ไขรายการ</th>
                          </tr></thead><tbody>";
                    $no = 1;
                    foreach ($shop['products'] as $prod) {
                        echo "<tr>";
                        echo "<td>{$no}</td>";
                        echo "<td>" . htmlspecialchars($prod['pd_n']) . "</td>";
                        echo "<td>" . htmlspecialchars($prod['quantity']) . "</td>";
                        echo "<td>" . number_format($prod['sp_price'], 2) . " บาท</td>";
                        echo "<td><a href='edit.php?pl_id={$prod['pl_id']}' class='btn btn-warning btn-sm'>แก้ไข</a></td>";
                        echo "</tr>";
                        $no++;
                    }
                    echo "</tbody></table>";
                    echo "</div>";
                    $active = ""; // แค่ tab แรก active
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- เพิ่ม script Bootstrap (ถ้ายังไม่มี) -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>





<?php
include('_footer.php');
?>