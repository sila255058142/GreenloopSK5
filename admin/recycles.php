<?php 
    require '../init.php';
    require __DIR__ . '/../controller/admin_recycle.php';
    head('จัดการรีไซเคิล');
?>
<div class="table-responsive">
    <table id="RecyTable" class="table table-striped bg-white align-middle">
        <thead>
            <tr>
                <th>สมาชิก</th>
                <th>รูป</th>
                <th>รายการ</th>
                <th>ประเภทขนส่ง</th>
                <th>ที่อยู่</th>
                <th>กก.</th>
                <th>สถานะ / จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= e($r['member']) ?></td>
                <td>
                    <?php if (!empty($r['image'])): ?>
                        <a href="../uploads/<?= e($r['image']) ?>" target="_blank" rel="noopener">
                            <img src="../uploads/<?= e($r['image']) ?>" alt="รูปสินค้า" style="max-width:70px; max-height:56px; object-fit:cover;">
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?= e($r['item_name']) ?></td>
                <td><?= $r['delivery_type'] === 'pickup' ? 'รับที่บ้าน' : 'นำส่งเอง' ?></td>
                <td><?= nl2br(e($r['address'])) ?></td>
                <td><?= e($r['weight_kg']) ?></td>
                <td>
                    <?php if ($r['status'] === 'pending'): ?>
                        <form method="post" class="d-flex gap-1">
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button class="btn btn-sm btn-success" type="submit">รับ</button>
                            <button class="btn btn-sm btn-outline-danger" type="submit" name="rejected" value="1" formnovalidate onclick="return confirm('ปฏิเสธคำขอนี้?')">ปฏิเสธ</button>
                        </form>
                    <?php else: ?>
                        <span class="badge bg-<?= $r['status'] === 'done' ? 'success' : 'secondary' ?>">
                            <?= $r['status'] === 'done' ? 'สำเร็จ' : 'ปฏิเสธ' ?>
                        </span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
$(document).ready(() => $('#RecyTable').DataTable());
</script>
<?php foot(); ?>