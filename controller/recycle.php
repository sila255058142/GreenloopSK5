<?php
require_once __DIR__ . '/../init.php';

$u = me();
if(!$u) go('login.php' , 'เข้าสู่ระบบ' , 'warning');
$cats = ($db->query('SELECT * FROM categories ORDER BY id'))->fetch_all(MYSQLI_ASSOC);
$uId = (int) $u['id'];

if($_POST){
    $cateId = (int) ($_POST['category_id'] ?? 0);
    $stmt = $db->prepare ('SELECT * FROM categories WHERE id = ?');
    $stmt->bind_param('i', $cateId);
    $stmt->execute();

    $cate = $stmt->get_result()->fetch_assoc();

    $itemName = trim($_POST['item_name']?? '');
    $weight = trim($_POST['weight_kg']?? 0);
    $deli = trim($_POST['delivery_type']?? '');
    $address = trim($_POST['address']?? '');
    if (mb_strlen($itemName)< 3 || $weight <= 0 || !$cate || !in_array($deli, ['self', 'pickup'], true)){

        go('recycle.php', 'ตรวจสอบข้อมูล' , 'danger');
    }
    $image = upload('image');
    $mCo2 = $weight * $cate['co2_per_kg'];
    $stmt = $db->prepare('INSERT INTO recycles(user_id, category_id , item_name, weight_kg, image, delivery_type, address) VALUES(?,?,?,?,?,?,?)');
    $stmt->bind_param('iisdsss',$uId, $cateId,$itemName,$weight,$image,$deli,$address);
    $stmt->execute();
$title = 'คำขอ';
    $message = ($_POST['message']?? '');
    $link = 'admin_recycles.php';
    $db->query("INSERT INTO notifications (user_id, title, message , link) VALUES (Null,'$title' ,' $message' ,' $link ')");

    $stmt = $db->prepare("INSERT INTO notifications (user_id , title , message , link) VALUES (NULL ,?,?,'admin/status?status=pending')");
    
    $stmt->bind_param('ss',$title,$message);
    $stmt->execute();

    go('recycle.php#recycle-form' , 'ส่งคำ');


}
    $year = (int) date('Y');
    $stmt = $db->prepare("SELECT COALESCE(SUM(co2_kg), 0) As total FROM recycles WHERE user_id = ? AND status = 'done' AND YEAR(created_at) = ?");
    $stmt->bind_param('ii', $uId, $year);
    $stmt->execute();
    $saved = $stmt->get_result()->fetch_assoc()['total'] ?? null;