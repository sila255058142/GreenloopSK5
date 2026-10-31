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

    if(isset($_POST['rejected'])){
        $db->query("UPDATE recycles SET status = 'rejected' WHERE id = $rId");
        $db->commit();

        if ($r){
            $title = 'คำขอ';
             $message = mb_substr($r['item_name']. 0 , 500);
             $link = 'recycle.php';
             $db->query("INSERT INTO notifications (user_id, title, message,link) VALUES ({$r['user_id']}, '$title', '$message', '$link')");

        }
        go('recycle.php' , 'ปฏิเสธ', 'warning');
    }
    $kg = (float) trim($_POST['weight_kg']?? '');
    $points  = (int) round($kg * 20);
    $co2 = $kg * (float) $r['co2_per_kg'];
    
    $db->query ("UPDATE recycles SET STATUS = 'done', weight_kg = $kg , points = $points, co2_kg = $co2 WHERE id = $rId ");
       $db->query ("UPDATE users SET points = points + $points WHERE id = {$r['user_id']}");

       $description = 'แต้มรีไซเคิล:' . $r['item_name'];
       $db->query("INSERT INTO point_transactions (user_id, amount, description, related_type, related_id) VALUES ({$r['user_id']}, $points, '$description', 'recycle' , $rId)");
        $db->commit();

        $title = "ีไซเคิลสำเร็จ รับ $points แต้ม";
        $message = mb_substr($r['item_name'] . 'ลดคาร์บอนได้' . $co2 . 'kgCo2e', 0,500);
        $link = 'points.php';
        $db->query("INSERT INTO notifications (user_id, title,message,link) VALUES ({$r['user_id']} , '$title' , '$message' , '$link')");

        go('recycles.php' , "ได้รับ $points");

    }
    $s = trim($_GET['q'] ?? '');
    $status = trim($_GET['status'] ?? '');


    $sql = "SELECT r.* ,c.name AS category, u.name AS member
    FROM recycles r
    JOIN categories c ON c.id = r.category_id
    JOIN users u ON u.id = r.user_id
    WHERE (r.item_name LIKE '%$s%' OR u.name LIKE '%$s%')
    AND ('$status' = '' OR r.status = '$status')
    ORDER BY r.status = 'pending' DESC , r.id DESC";

    $result = $db->query($sql);
    $rows = $result ? $result->fetch_all(MYSQLI_ASSOC): [];