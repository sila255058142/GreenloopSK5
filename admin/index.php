<?php
require __DIR__ . '/../controller/admin_index.php';
    head('Dashboard',false); 
?>
<div class="text-left mt-3">
<h1 class="mt-3">GreenLoop DashBoard</h1>
<button class="btn btn-success mb-3 d-print-none mt-3" type="button" onclick="window.print()">พิมพ์รายงาน</button>
    <p class="mt-2">วันทีพิมพ์: <?= date('d/m/Y H:i') ?></p>
</div>
<div class="row g-3 mt-3">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-body box text-center mb-3">
            <small class="text-muted">🫂สมาชิกทั้งหมด</small>
            <h4 class="text-success mb-0"><?= $memberCount ?> คน</h4>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card card-body box text-center h-100 mb-0">
            <small class="text-muted">🚫สมาชิกที่ถูกระงับ</small>
            <h4 class="text-success mb-0"><?= $suspendedCount ?> คน</h4>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-body box text-center h-100 mb-0">
            <small class="text-muted">⌛คำขอรีไซเคิลรอตรวจรับ</small>
            <h4 class="text-success mb-0"><?= $pendingRecycleCount?> ราย</h4>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-body box text-center h-100 mb-0">
            <small class="text-muted">🎟️คำขอแลกคูปองรออนุมัติ</small>
            <h4 class="text-success mb-0"><?= $pendingcouponCount ?> คน</h4>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-body box text-center h-100 mb-0">
            <small class="text-muted">🔔แจ้งเตือนที่ยังไม่อ่าน</small>
            <h4 class="text-success mb-0"><?= $unreadNotificationCount ?> คน</h4>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-body box text-center h-100 mb-0">
            <small class="text-muted">📦E-waste ที่รีไซเคิล</small>
            <h4 class="text-success mb-0"><?= $sum['kg'] ?> กก.</h4>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-body box text-center h-100 mb-0">
            <small class="text-muted">🌍คาร์บอนที่ลดได้</small>
            <h4 class="text-success mb-0"><?= $sum['co2'] ?> คน</h4>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-body box text-center h-100 mb-0">
            <small class="text-muted">🌳เทียบเท่าต้นไม้</small>
            <h4 class="text-success mb-0"><?= round($sum['co2'] / 9.5, 1) ?> ต้น</h4>
        </div>
    </div>
</div>
<div class="row mt-3 g-3">
    <div class="col-lg-8">
        <div class="card card-body mb-3">
            <h6>คาร์บอนที่ลดได้รายเดือน (kgCO2e)</h6>
            <canvas id="carbon-chart"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-body mb-3">
            <h6>น้ำหนักที่รีไซเคิลตามหมวด (กก.)</h6>
            <canvas id="category-chart"></canvas>
        </div>
    </div>
        <div class="col-lg-4">
        <div class="card card-body mb-3">
            <h6>สมาชิกใหม่รายเดือน</h6>
            <canvas id="member-chart"></canvas>
        </div>
    </div>
</div>

<script>
    $(document).ready(function()    {
    new Chart($('#carbon-chart')[0],{
        type: 'bar',
        data:   {
            labels: <?= json_encode(array_column
            ($byMonth, 'm'), JSON_HEX_TAG |
            JSON_HEX_APOS | JSON_HEX_QUOT |
            JSON_HEX_AMP)?>,
            datasets:   [{label: 'คาร์บอนทีลดได้รายเดือน (kgCO2e)', data: <?= json_encode(array_column($byMonth, 'v'))?>}]
        }
    });
    new Chart($('#category-chart')[0],{
        type: 'pie',
        data:   {
            labels: <?= json_encode(array_column
            ($byMonth, 'm'), JSON_HEX_TAG |
            JSON_HEX_APOS | JSON_HEX_QUOT |
            JSON_HEX_AMP)?>,
            datasets:   [{label: 'น้ำหนักที่รีไซเคิล (กก.))', data: <?= json_encode(array_column($byMonth, 'v'))?>}]
        }
    });
    new Chart($('#member-chart')[0],{
        type: 'line',
        data:   {
            labels: <?= json_encode(array_column
            ($byMonth, 'm'), JSON_HEX_TAG |
            JSON_HEX_APOS | JSON_HEX_QUOT |
            JSON_HEX_AMP)?>,
            datasets:   [{label: 'สมาชิกใหม่รายเดือน (คน)', data: <?= json_encode(array_column($byMonth, 'v'))?>}]
        }
    });
});
</script>
<?php foot()    ?>