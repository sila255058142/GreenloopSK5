<?php
require __DIR__ . '/../controller/admin_notifications.php';
head('การแจ้งเตือน');
?>
<?php foreach ($rows as $r): ?>
    <div class="card card-body mb-2">
        <div>
            <b><?= e($r['title']) ?></b>
            <br>
            <?= e($r['message']) ?>
            <br>
            <small class="text-muted">
                <?= $r['created_at'] ? date('d/m/Y H:i', strtotime($r['created_at'])) : '-' ?>
            </small>
        </div>
    </div>
<?php endforeach; ?>
<?php if (!$rows): ?>
    <div class="alert alert-secondary">ไม่มีการแจ้งเตือน</div>
<?php endif; ?>
<?php foot(); ?>
