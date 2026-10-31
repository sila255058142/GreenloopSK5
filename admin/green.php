<?php
    require __DIR__ . '/../controller/admin_green.php';

    head('จัดการเนื้อหา');
?>
<div class="card card-body">
    <h5>หมวดขยะอิเล็กทรอนิกส์ (kgCO2e ที่ลดได้เมื่อรีไซเคิล 1 กก.)</h5>
        <?php foreach ($cats as $c): ?>
            <form action="" method="post" class="row g-2 mb-2">
                <input type="hidden" name="id" value="<?= $c['id']?>">
                <div class="col-md-7">
                    <input class="form-control" name="name" value="<?= e($c['name'])?>" placeholder="ชื่อหมวด" required>
                </div>
                <div class="col-md-2">
                    <input class="form-control" name="co2_per_kg" type="number" step="0.01" min="0.01" value="<?= e($c['co2_per_kg'])?>"  required>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success" name="save_category"><?= $c ['id'] ? 'บันทึก' : 'เพิ่ม' ?></button>
                    <?php if ($c['id']): ?>
                    <button class="btn btn-outline-danger" name="del_category" onlick="return confirm('ลบหมวดนี้')">ลบ</button>
                    <?php endif; ?>
                </div>
            </form>
        <?php endforeach; ?>
</div>
<?php foot() ?>