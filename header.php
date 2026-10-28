<?php
 function head($title, $show = true)   {
  $u = me();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?> | GreenLoop</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="lib/datatables.min.css">
    <script src="lib/chart.umd.js"></script>
    <script src="lib/datatables.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark d-print-none">
        <div class="container">
            <a href="index.php" class="navbar-brand fw-bold">♻️GreenLoop</a>
            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <div class="navbar-nav me-auto">
                    <?php if ($u && $u['role'] == 'admin'): ?>
                        <a href="../admin/indexs.php" class="nav-link">DashBoard</a>
                        <a href="../admin/content.php" class="nav-link">เนื้อหา</a>
                        <a href="../admin/green.php" class="nav-link">ตั้งค่า Green</a>
                        <a href="../admin/recycles.php" class="nav-link">รีไซเคิล</a>
                        <a href="../admin/coupons.php" class="nav-link">คูปอง</a>
                        <a href="../admin/reports.php" class="nav-link">รายงาน</a>
                    <?php elseif ($u): ?>
                        <a href="recycle.php" class="nav-link">รีไซเคิล</a>
                        <a href="points.php" class="nav-link">แต้มของฉัน</a>
                        <a href="coupons.php" class="nav-link">แลกคูปอง</a>
                        <a href="profile.php" class="nav-link">โปรไฟล์</a>
                    <?php endif;?>
                </div>
                <div class="navbar-nav align-items-lg-center">
                    <?php if(!$u): ?>
                        <a href="login.php" class="navlink">เข้าสู่ระบบ</a>
                        <a href="register.php" class="navlink">สมัครสมาชิก</a>
                    <?php else: ?>
                        <a href="notification.php" class="nav-link">
                            <span class="badge bg-danger">🎄</span>
                        </a>
                        <span class="navbar-text text-white mx-2">
                            <p>ice</p>
                        </span>
                        <a href="logout.php" class="nav-link">ออกจากระบบ</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="container py-4">
    <?php if ($show):   ?>
        <h3 class="mb-3"><?= $title ?></h3>
    <?php endif; ?>
<?php
}

function foot() {
    echo '</main><footer class="text-center text-muted small py-4 d-print-none">GreenLoop | วัคคาร์บอน ลดด้วยการรีไซเคิล เพื่อโลกที่ยั่งยืน</footer><script src="assets/bootstrap.bundle.min.js"></script></body></html>';
}