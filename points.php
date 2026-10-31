<?php
require 'init.php';
require 'controller/points.php';
head('แต้มของฉัน',false);
$medals = ['🥇','🥈','🥉','🏅','🎖️'];
$points = (int) $u['points'];
$currentlevel = $points >= 600 ? '🌍 Net Zero Hero':
                ($points >= 300 ? '🌳ต้นไม้':
                ($points >= 100 ? '🌱 ต้นกล้า':
                '😀 มือใหม่'));
$next = $points >= 600 ? 0 : ($points >= 300 ? 600 : ($points >= 100 ? 300: 100));
$nextlevel = $points >= 300 ? '🌍' : ($points >= 100 ? '🌳' : '🌱');
?>
<!-- <div class="hero d-flex flex-column align-items-center justify-content-center mb-2"> -->
<div class="hero text-center mb-4">
    <div class="fs-1" aria-hidden="true">👤</div>
    <div class="fs-1 lh-sm"><?= $currentlevel ?></div>
        <p class=""><?= $u['points']?> แต้ม<?= $next ? '. อีก '. ($next - $u['points']) .' แต้ม จะเลื่อนเป็น ' . $nextlevel : '. ระดับสูงสุดแล้ว'?></p>
            <?php if ($next): ?>
                <div class="progress">
                    <div class="progress-bar bg-warning" style="width:<?= round($u['points'] / $next * 100)?>%">
                    </div>
                </div>
            <?php endif; ?>
</div>
<div class="row justify-content-center">
    <div class="col-6 col-lg-3">
        <div class="card card-body box text-center">
            <small class="text-muted">✅รีไซเคิลสำเร็จ</small>
            <h4 class="text-success mb-0">
                <?= $sum['n']?>ครั้ง
            </h4>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-body box text-center">
            <small class="text-muted">🌍คาร์บอนที่ลดได้</small>
            <h4 class="text-success mb-0">
                <?= $sum['co2']?>kgCO2e
            </h4>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card card-body box text-center">
            <small class="text-muted">🌳เทียบเท่าต้นไม้</small>
            <h4 class="text-success mb-0">
                <?= round($sum['co2'] / 9.5, 1)?>ต้น
            </h4>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col">
        <h3 class="text-center"> 🎖️อันดับสมาชิกแต้มสูงสุด🎖️</h3>
        <table id = "topPointstable" class="table mb-0">
            <thead>
                <tr>
                    <th>อันดับ</th>
                    <th>ชื่อ</th>
                    <th>ระดับ</th>
                    <th class="text-end">แต้ม</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($top as $i => $t): ?>
                    <?php $memberLevel = match(true)    {
                    $t['points'] >= 600 => '🌍',
                    $t['points'] >= 300 => '🌳',
                    $t['points'] >= 100 => '🌱',
                    default => '😀', 
                    };
                    ?>
                    <tr class="<?= $t['id'] == $u['id'] ? 'table-success' : ''?>">
                        <td><?= $medals[$i]?></td>
                        <td><?= e($t['name'])?></td>
                        <td><?= $memberLevel ?></td>
                        <td class="text-end"><?= $t['points']?>แต้ม</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        const table = $('#topPointstable').DataTable();
    });
</script>
<?php foot() ?>