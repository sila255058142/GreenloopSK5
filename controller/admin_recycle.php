<?php
require_once __DIR__ . '/../init.php';
$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน' , 'warning');
if  ($admin['role'] !== 'admin') go('../index.php' , 'สำหรับแอดมิน' , 'danger');
if($_POST){
    $db->begin_Transaction();
    $rId = (int) ($_POST['id'] ?? 0);

    $result = $db->query("SELECT r.*, c.co2_per_kg FROM recycles r JOIN categories c ON c.id = r.category_id WHERE r.id = $rId AND r.status = 'pending' FOR UPDATE");
    $r = $result ? $result->fetch_assoc() : null;

    if (isset($_POST['rejected'])) {
        $db->query("UPDATE recycles SET status = 'rejected' WHERE id = $rId");
        $db->commit();

        if ($r) {
            $message = mb_substr($r['item_name'], 0, 500);
            $db->query("INSERT INTO notifications (user_id, title, message, link) VALUES ({$r['user_id']}, 'คำขอ', '$message', 'recycle.php')");
        }
        go('recycles.php', 'ปฏิเสธ', 'warning');
    }

    $kg = (float) ($_POST['weight_kg'] ?? 0);
    $points = (int) round($kg * 20);
    $co2 = $kg * (float) $r['co2_per_kg'];
    $db->query("UPDATE recycles SET status = 'done', weight_kg = $kg, points = $points, co2_kg = $co2 WHERE id = $rId");
    $db->query("UPDATE users SET points = points + $points WHERE id = {$r['user_id']}");
    $db->query("INSERT INTO point_transactions (user_id, amount, description, related_type, related_id) VALUES ({$r['user_id']}, $points, 'แต้มรีไซเคิล:{$r['item_name']}', 'recycle', $rId)");
    $db->commit();

    $message = mb_substr($r['item_name'] . 'ลดคาร์บอนได้' . $co2 . 'kgCo2e', 0, 500);
    $db->query("INSERT INTO notifications (user_id, title, message, link) VALUES ({$r['user_id']}, 'รีไซเคิลสำเร็จ รับ $points แต้ม', '$message', 'points.php')");
    go('recycles.php', "ได้รับ $points");
}

$s = trim($_GET['q'] ?? '');
$status = trim($_GET['status'] ?? '');

$sql = "SELECT r.*, c.name AS category, u.name AS member
    FROM recycles r
    JOIN categories c ON c.id = r.category_id
    JOIN users u ON u.id = r.user_id
    WHERE (r.item_name LIKE '%$s%' OR u.name LIKE '%$s%')
    AND ('$status' = '' OR r.status = '$status')
    ORDER BY r.status = 'pending' DESC, r.id DESC";

$result = $db->query($sql);
$rows = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];