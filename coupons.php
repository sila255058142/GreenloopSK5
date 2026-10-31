<?php
require 'init.php';
require 'controller/coupon.php';
head('แลกของรางวัล')
?>
<div class="bg-success text-white rounded p-4 mb-4">
    <p class="lead mb-1">แต้มของคุณ</p>
    <div class="fs-1 lh-sm"><?= number_format($balance)?> แต้ม</div>
    <p class="mb-0"></p>
</div>
<h3 class="mb-4">🎁ของรางวัล</h3>
<div class="row g-3">
    <?php foreach ($rewards as $r): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card card-body h-100">
                <h5><?= e($r['title'])?></h5>
                <p class="text-muted"><?= nl2br(e($r['description']))?></p>
                <p class="text-muted"><?= e($r['points_cost'])?> แต้ม | คงเหลือ <?= $r['stock'] === null ? 'ไม่จำกัด' : number_format($r['stock'])?>ชิ้น</p>
                <form method="post" class="mt-auto" onsubmit="return confirm('ยืนยันขอแลกของรางวัลนี้หรือไม่')">
                    <input type="hidden" name="reward_id" value="<?= $r['id']?>">
                    <button class="btn btn-success w-100" name="redeem"<?= $balance < $r['points_cost'] ? 'disabled' : ''?>>แลกรางวัล</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php if (!$rewards) : ?>
    <div class="alert alert-secondary mt-2">ยังไม่มีของรางวัล</div>
<?php endif; ?>
<h3 class="mt-4">🎟️คูปองของฉัน</h3>
    <div class="table-responsive">
        <table class="table table-stripped bg-white align-middle" id="couponTable">
            <thead>
                <tr>
                    <th>ของรางวัล</th>
                    <th>แต้มที่ใช้</th>
                    <th>สถานะ</th>
                    <th>วันที่แลก</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($myCoupons as $coupon): ?>
                    <tr>
                        <td><?= e($coupon['title'])?></td>
                        <td><?= e($coupon['points_spent'])?></td>
                        <td><?= $coupon['status'] === 'pending' ? 'รออนุมัติ' : ($coupon['status'] === 'used' ? 'ใช้แล้ว' : e($coupon['status']))?></td>
                        <td data-order=<?= e(strtotime($coupon['created_at']))?>>
                            <?= e(date('d/m/Y H:i', strtotime($coupon['created_at'])))?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
    $(document).ready(function ()   {
        const table = $('#couponTable').DataTable();
    });
</script>
<?php foot() ?>