<?php
require 'init.php';
require 'controller/profile.php';
head('โปรไฟล์ของฉัน');
$currentLevel = $u['points'] >= 600 ? '🌍' : ($u['points'] >= 300 ? '🌳' : ($u['points'] >= 100 ? '🌱' : '😀'));
?>
<div class="row">
    <div class="col-lg-6">
        <form method="post" class="card card-body mb-3">
            <div class="text-center">
                <div class="fs-1">👤</div>
                <div class="mt-2"><?= $currentLevel ?> | <?= $u['points']?> แต้ม</div>
            </div>
                <label class="form-label mt-2">ชื่อ-นามสกุล</label>
                <input class="form-control" type="text" name="name" required value="<?= e($u['name'])?>">
                <label class="form-label mt-2">อีเมล</label>
                <input class="form-control" type="email" name="email" value="<?= e($u['email'])?>" required>
                <label class="form-label mt-2">เบอร์โทรศัพท์ (ตัวเลข 10 หลัก)</label>
                <input class="form-control" type="text" name="phone" value="<?= e($u['phone'])?>" maxlength="10" inputmode="numeric" pattern="0[0-9]{9}" title="ตัวเลข 10 หลัก ขึ้นต้นด้วย 0">
                <button class="btn btn-success mt-3" name="save">บันทึก</button>
        </form>
    </div>
    <div class="col-lg-6">
        <form method="post" class="card card-body mb-3">
            <h5>เปลี่ยนรหัสผ่าน</h5>
                <label class="form-label mt-2">รหัสผ่านปัจจุบัน</label>
                <input class="form-control" type="password" name="current" value="" required>
                <label class="form-label mt-2">รหัสผ่านใหม่</label>
                <input class="form-control" type="password" name="password" value="" required minlength="8">
                <label class="form-label mt-2">ยืนยันรหัสผ่านใหม่</label>
                <input class="form-control" type="password" name="password" value="" required>                
                <button class="btn btn-success mt-3" name="change">เปลี่ยนรหัสผ่าน</button>
        </form>
    </div>
</div>
<?php foot() ?>