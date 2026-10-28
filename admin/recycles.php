<?php 
    require '../init.php';
    head('จัดการรีไซเคิล');
    // require __DIR__ . '/../controllers/admin/'
?>
    <div class="table-reponsive">
        <table id ="myTable" class="table table-stripped bg-white align-middle"> 
            <thead>
                <tr>
                    <th>รูป</th>
                    <th>วันที่</th>
                    <th>สมาชิก</th>
                    <th>รายการ</th>
                    <th>หมวด</th>
                    <th>กก.</th>
                    <th>ขนส่ง</th>
                    <th>ที่อยู่</th>
                    <th>สถานะ</th>
                    <th>แต้ม</th>
                    <th>CO2e ที่ลด</th>
                    <th>ตรวจจับ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                    <?php 
                        $id = $r['id'] ?? '';
                        $image =$r['image'] ?? ''; 
                        $createdAt =$r['created_at'] ?? ''; 
                        $status =$r['status'] ?? ''; 
                    ?>
                        <tr>
                            <td>
                                <?php if ($image !== ''): ?>
                                    <a href="../uploads/<?=e($image) ?>" target="_blank" rel="noopener">
                                        <img src="../uploads/<?= e($image)?>" alt="รูปสินค้า" style="max-width:70px; max-height:56px; object-fit:cover;">
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                                <td data-order="<?= $createdAt !== '' ? strtotime($createdAt) : 0 ?>">
                                    <?= $createdAt !== '' ? e(date('d/m/Y H:i', strtotime($createdAt))) : '-' ?>
                                </td>
                                <td><?= e($r['member'] ?? '')?></td>
                                <td><?= e($r['item_menu'] ?? '')?></td>
                                <td><?= e($r['category'] ?? '')?></td>
                                <td><?= e($r['weight_kg'] ?? '')?></td>
                                <td><?= e(deliveryType($r[delivery_type] ?? ''))?></td>
                                <td><?= nl2br(e($r['weight_kg'] ?? ''))?></td>
                                <td><?= e($r['points'] ?? '')?></td>
                                <td><?= e($r['co2_kg'] ?? '')?></td>
                                <td><?= e($r['weight_kg'] ?? '')?></td>
                                <td>
                                    <?php if ($status === 'pending'): ?>
                                        <form method="post" class="d-flex gap-1">
                                            <input type="hidden" name="id" value="<?= e($id)?>">
                                            <input type="number" name="weight_kg" value="<?= e($r['weight_kg']) ?? '' ?>">
                                            <button class="btn btn-sm btn-success" type="submit">ตรวจรับ</button>
                                            <button class="btn btn-sm btn-outline-danger" type="reject" formnovalidateonclick="return confirm('ปฏิเสธคำขอนี้?')">ปฏิเสธ</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                        </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function ()   {
            new DataTable('#recycleTable',(
                order:[]
            ));
        });
        </script>
        <?php foot(); ?>