<?php
require 'controller/notifications.php';
head('การแจ้งเตือน');
?>
<form method="get" class="d-flex flex-wrap gap-2 md-3 d-print-none mb-4">
    <input class="form-control w-auto" name="q" value="<?= isset    ($_GET['q']) ? e(trim($_GET['q'])): '' ?>" placeholder="ค้นหา...">
    <button class="btn btn-success">ค้นหา</button>
</form>
<?php foreach ($rows as $r): ?>
    <div class="card card-body mb-2 <?= $r['is_read'] ? '' : 'border border-success'?>">
        <form method="post" class="d-flex justify-content-between gap-2">
            <div>
                <b><?= e($r['title'])?></b>
                <?= $r['is_read'] ? '' : '<span class="badge bg-danger">ใหม่</span>'?>
                <br>
                <?= e($r['message'])?>
                <br>
                <small class="text-muted">
                    <?= ($r['created_at'] ? date('d/m/Y H:i', strtotime($r['created_at'])) : '-')?>
                </small>
            </div class="text-nowrap">
            <div>
                <input type="hidden" name="id" value="<?= $r['id']?>">
                <?php if ($r['link']): ?>
                <a class="btn btn-sm btn-success" href="<?= e($r['link'])?>">เปิด</a>
                <?php endif; ?>
                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('ลบการแจ้งเตือนนี้?')">ลบ</button>
            </div>
        </form>
    </div>
<?php endforeach; ?>
<?php if (!$rows): ?>
    <div class="alert alert-secondary">
        ไม่มีการแจ้งเตือน
    </div>
<?php endif; ?>
<?php foot() ?>