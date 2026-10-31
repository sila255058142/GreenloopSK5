<?php
require 'init.php';
require 'controller/home.php';
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
            <span class="section-eyebrow">SMALL ACTION, BIG impact</span>
            <h2>ผลกระทบที่เราต่างร่วมกัน 🎄</h2>
            <p>ทุกชิ้นที่ส่งเข้าระบบ ืออีกหนึ่งก้าวของการจัดการขยะ E-waste อย่างรับผิดชอบ</p>
        </div>
        <div class="row g-3 home-impact-grid">
            <div class="col-6 col-xl-3">
                <div class="impact-card h-100 p-4 bg-white">
                    <span class="impact-logo fs-3">🫂</span>
                    <span class="impact-label">คนที่ร่วมดูโลก</span>
                    <strong class="d-block fs-3 text-success"><?= number_format($MC) ?></strong>
                    <small>สมาชิก GreenLoop</small>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="impact-card h-100 p-4 bg-white">
                    <span class="impact-logo fs-3">♻️</span>
                    <span class="impact-label">ส่งต่ออย่างถูกวิธี</span>
                    <strong class="d-block fs-3 text-success"><?= number_format($sum['n'])?></strong>
                    <small>รายการที่รีไซเคิลสำเร็จ</small>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="impact-card h-100 p-4 bg-white">
                    <span class="impact-logo fs-3">📦</span>
                    <span class="impact-label">ขยะที่ไม่ถูกทิ้งเปล่า</span>
                    <strong class="d-block fs-3 text-success"><?= number_format((float) $sum['kg'], 2) ?></strong>
                    <small>กิโลกรัม E-waste</small>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="impact-card h-100 p-4 impact-card-highlight">
                    <span class="impact-logo fs-3">🌍</span>
                    <span class="impact-label">ลดการปล่อยคาร์บอน</span>
                    <strong class="d-block fs-3 text-success"><?= number_format((float) $sum['co2'], 2) ?></strong>
                    <small>kgC02e จากรายการที่สำเร็จ</small>
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
<section class="article-section mt-5 mb-4">
    <div class="articles-heading d-flex align-items-center justify-content-between gap-3">
        <div>
            <span class="section-eyebrow">GREENLOOP JOURNAL</span>
            <h2>เรื่องเล็กๆ ก็ช่วยโลกได้</h2>
            <p>ข่าวสารและความรู้เรื่อง E-waste ที่อ่านง่ายและใช้ได้จริง</p>
        </div>
        <span class="article-count"><?= $FN ? count($new) + 1 : 0?> เรื่อง</span>
    </div>
    <div class="article-toolbar d-flex justify-content-between align-items-center gap-3">
        <span>บทความต่างๆ</span>
    </div>
    <?php if ($FN): ?>
        <article class="card article-feature row g-0 m-0 overflow-hidden mb-4">
            <div class="article-art col-md-5 d-grid w-100 h-100 align-items-center justify-content-between position-relative" aria-hidden="true">
                <span class="article-art-orbit"></span>
            </div>
            <div class="article-feature-content col-md-4 pd-4 p-lg-5">
                <span class="article-label">เรื่องเล่น</span>
                <h3><?= e($FN['title']) ?></h3>
                <p><?= nl2br(e($FN['body']))?></p>
                <small class="text-muted"><?= ($FN['start_at'])?></small>
            </div>
        </article>
        <?php if ($new): ?>
            <div class="row">
                <?php foreach ($new as $index => $n): ?>
                    <div class="col-md-6 col-xl-4 mb-4">
                        <article class="card article-card h-100 p-4 mb-3">
                            <div class="article-card-top d-flex align-items-center justify-content-between gap-3">
                                <span class="article-card-icon"><?= $index % 2 === 0 ? '🌿' : '💡'?></span>
                                <small class="text-muted"><?= ($n['start_at'] ? date('d/m/y H:i', strtotime($n['start_at'])) : '-')?></small>
                            </div>
                            <h4><?= e($n['title'])?></h4>
                            <p><?= nl2br(e($n['body']))?></p>
                            <span class="article-read-label">GREENLOOP JOURNAL</span>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-secondary">ไม่พบข่าวสาร</div>
    <?php endif; ?>
</section>
<?php  foot()?>