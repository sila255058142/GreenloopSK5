<?php
require 'init.php';
    $u = me();
    $steps = [
        ['📦','1. แจ้งรายการ','เลือกหมวดและกรอกข้อมูลอุปกรณ์ที่ต้องการส่งรีไซเคิล','recycle.php#recycle-form'],
        ['🔎','2. รอตรวจจับ','ทีมงานตรวจสอบข้อมูลและยืนยันการรีไซเคิล','recycle.php'],
        ['🏆','3. รับแต้มและเติบโต','เมื่อรายการสำเร็จ รับแต้มสะสมเพื่อแลกของรางวัล','points.php'],
    ];
head('หน้าแรก',false);
?>
<div class="container p-4">
    <div class="hero mb-4">
        <?php if ($u): ?>
            <h1>สวัสดี<?= e($u['name'])?>👋</h1>
            <p class="lead"></p>
            <a href="recycle.php#recycle-form" class="btn btn-light">รีไซเคิล</a>
            <a href="points.php" class="btn btn-outline-light">ดูแต้มสะสม</a>
        <?php else: ?>
            <h1>ส่งขยะอิเล็กทรอนิกส์ไปรีไซเคิล</h1>
            <p class="lead">ร่วมจัดการขยะ E-waste อย่างถูกวิธี ดูผลกระทบต่อสิ่งแวดล้อมและรับแต้มสะสมเมื่อรีไซเคิลสำเร็จ</p>
            <a href="register.php" class="btn btn-light">สมัครสมาชิก</a>
            <a href="login.php" class="btn btn-outline-light">เข้าสู่ระบบ</a>
        <?php endif; ?>
    </div>
    <section class="home-impact-section">
        <div class="home-section-heading">
            <span class="section-eyebrow"></span>
            <h2></h2>
            <p></p>
        </div>
        <div class="row g-3 home-impact-grid">
            <div class="col-6 col-xl-3">
                <div class="impact-card h-100 p-4 bg-white">
                    <span class="impact-logo fs-3"></span>
                    <span class="impact-label"></span>
                    <strong></strong>
                    <small></small>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="impact-card h-100 p-4 bg-white">
                    <span class="impact-logo fs-3"></span>
                    <span class="impact-label"></span>
                    <strong></strong>
                    <small></small>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="impact-card h-100 p-4 bg-white">
                    <span class="impact-logo fs-3"></span>
                    <span class="impact-label"></span>
                    <strong></strong>
                    <small></small>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="impact-card h-100 p-4 impact-card-highlight">
                    <span class="impact-logo fs-3"></span>
                    <span class="impact-label"></span>
                    <strong></strong>
                    <small></small>
                </div>
            </div>
        </div>
        <a href="" class="impact-footnote"></a>
    </section>
    <section class="home-journey-section">
        <div class="home-section-heading mt-5 mb-4">
            <span class="section-eyebrow"></span>
            <h2></h2>
            <p></p>
        </div>
        <div class="row g-3">
            <?php foreach ($steps as $index => $s): ?>
                <div class="col-md-4">
                    <a href="<?= e($s[3]) ?>" class="card journey-card h-100 p-4 text-decoration-none">
                        <div class="journy-card-top d-flex align-items-center justify-content-between gap-3">
                            <span class="journy-icon"><?= $s[0]?></span>
                            <span class="journy-number"></span>
                        </div>
                        <h3><?= $s[1]?></h3>
                        <p><?= $s[2]?></p>
                        <?php if ($index === 2): ?>
                            <span class="journey-reward">🎁 20 แต้มต่อกิโลกรัม</span>
                        <?php endif;    ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="home-campaign d-flex justify-content-between gap-4 mt-5 rounded-4">
        <div class="campaign-decoration" aria-hidden="true">🌿</div>
        <div class="campaign-copy">
            <span class="section-eyebrow">ช่วยกันเปลี่ยนของเก่า ให้เป็นคุณค่าใหม่</span>
            <h2>ลิ้นชักของคุณอาจมีก้าวเล็กๆ ซ่อนอยู่</h2>
            <p>โทรศัพท์เสีย สายชาร์จเก่า หรืออุปกรณ์อิเล็กท์ทรอนิกส์ที่ไม่ได้ใช้ ไม่ควรถูกทิ้งร่วมกับขยะทั่วไป เริ่มต้นส่งต่ออย่างถูกวิธีแล้วชวนคนรอบตัวมาสร้างชุมชนที่ใส่ใจโลกไปด้วยกัน</p>
        </div>
        <a href="recycle.php#recycle-form" class="btn btn-light campaign-action">♻️เริ่มรีไซเคิล</a>
    </section>
</div>
<?php  foot()?>