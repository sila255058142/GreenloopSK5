<?php
require_once __DIR__ . '/../init.php';
$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน', 'warning');
if ($admin['role'] !== 'admin') go('../index.php', 'สำหรับแอดมิน', 'danger');

if ($_POST) {
    $db->begin_Transaction();
    $rId = (int) ($_POST['id'] ?? 0);

    $r = $db->query("SELECT r.*, c.co2_per_kg FROM recycles r JOIN categories c ON c.id = r.category_id WHERE r.id = $rId AND r.status = 'pending' FOR UPDATE")->fetch_assoc();

    if (!$r) {
        $db->rollback();
        go('recycles.php', 'ไม่พบข้อมูลหรือดำเนินการไปแล้ว', 'danger');
    }

    if (isset($_POST['rejected'])) {
        $db->query("UPDATE recycles SET status = 'rejected' WHERE id = $rId");
        $db->commit();
        $db->query("INSERT INTO notifications (user_id, title, message, link) VALUES ({$r['user_id']}, 'คำขอ', '{$r['item_name']}', 'recycle.php')");
        go('recycles.php', 'ปฏิเสธเรียบร้อย', 'warning');
    }

    $kg = (float) $r['weight_kg'];
    $points = (int) round($kg * 20);
    $co2 = $kg * (float) $r['co2_per_kg'];

    $db->query("UPDATE recycles SET status = 'done', points = $points, co2_kg = $co2 WHERE id = $rId");
    $db->query("UPDATE users SET points = points + $points WHERE id = {$r['user_id']}");
    $db->query("INSERT INTO point_transactions (user_id, amount, description, related_type, related_id) VALUES ({$r['user_id']}, $points, 'แต้มรีไซเคิล:{$r['item_name']}', 'recycle', $rId)");
    $db->commit();

    go('recycles.php', "สำเร็จ ได้รับ $points แต้ม");
}

$s = trim($_GET['q'] ?? '');
$status = trim($_GET['status'] ?? '');

$rows = $db->query("SELECT r.id, r.item_name, r.image, r.weight_kg, r.delivery_type, r.address, r.status, u.name AS member
    FROM recycles r JOIN users u ON u.id = r.user_id
    WHERE (r.item_name LIKE '%$s%' OR u.name LIKE '%$s%') AND ('$status' = '' OR r.status = '$status')
    ORDER BY r.id DESC")->fetch_all(MYSQLI_ASSOC);