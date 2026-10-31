<?php 
    require __DIR__ . '/../controller/admin_users.php';
    require_once '../init.php';
    head('จัดการข้อมูลสมาชิก');
?>
<div class="card card-body">
    <h5>สมาชิก</h5>
    <div class="table-responsive">
        <table id="userTable" class="table table-stripped bg-white align-middle">
            <thead>
                <tr>
                    <th>ชื่อ</th>
                    <th>อีเมล</th>
                    <th>เบอร์โทร</th>
                    <th>แต้ม</th>
                    <th>ระดับ</th>
                    <th>สถานะ</th>
                    <th>เปลี่ยนสิทธ์ผู้ใช้งาน</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                    <?php $memberLevel = match(true)    {
                                $r['points'] >= 600 => '🌍',
                                $r['points'] >= 300 => '🌳',
                                $r['points'] >= 100 => '🌱',
                                default => '😀', 
                                };
                                ?>
                                <tr>
                                    <td><?= e($r['name'])?></td>
                                    <td><?= e($r['email'])?></td>
                                    <td><?= e($r['phone'])?></td>
                                    <td><?= $r['points']?></td>
                                    <td><?= $memberLevel ?></td>
                                    <td><?= $r['status'] === 'active' ? 'ใช้งานได้' : 'ระงับสิทธ์' ?></td>
                                    <td>
                                        <form method="post" onsubmit="return confirm('ยืนยันเปลี่ยนสถานะ?')">
                                            <input type="hidden" name="id" value="<?= $r['id']?>">
                                            <button class="btn btn-sm btn-outline-<?=$r['status'] == 'active' ? 'danger' : 'success'?>" name="toggle_status">
                                                <?= $r['status'] == 'active' ? 'ระงับสิทธ์' : 'ยกเลิกระงับสิทธ์' ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function ()   {
        const table = $('#userTable').DataTable();
    });
</script>
<?php foot() ?>