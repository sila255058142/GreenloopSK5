<?php
require_once __DIR__ . '/../init.php';

$u = me();
if(!$u) go('login.php' , 'เข้าสู่ระบบ' , 'warning');


$cats = ($db->query('SELECT * FROM categories ORDER BY id'))->fetch_all(MYSQLI_ASSOC);
$uId = (int) $u['id'];

if($_POST){
    $cateId = (int) ($_POST['category_id'] ?? 0);
    
    // เปลี่ยนมาใช้ query แบบเช็ค ID ตรงๆ
    $cate = $db->query("SELECT * FROM categories WHERE id = $cateId")->fetch_assoc();

    $itemName = trim($_POST['item_name'] ?? '');
    $weight = trim($_POST['weight_kg'] ?? 0);
    $deli = trim($_POST['delivery_type'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (mb_strlen($itemName) < 3 || $weight <= 0 || !$cate || !in_array($deli, ['self', 'pickup'], true)){
        go('recycle.php', 'ตรวจสอบข้อมูล', 'danger');
    }

    $image = upload('image');
    $mCo2 = $weight * $cate['co2_per_kg'];

    // 1. บันทึกข้อมูลลงตาราง recycles แบบ query ตรงๆ
    $db->query("INSERT INTO recycles (user_id, category_id, item_name, weight_kg, image, delivery_type, address) 
                VALUES ($uId, $cateId, '$itemName', $weight, '$image', '$deli', '$address')");

    $title = 'คำขอ';
    $message = trim($_POST['message'] ?? '');
    $link = 'admin_recycles.php';

    // 2. บันทึกแจ้งเตือนชุดที่ 1 (แบบ query ตรงๆ ตามที่คุณเขียนเพิ่มมา)
    $db->query("INSERT INTO notifications (user_id, title, message, link) 
                VALUES (NULL, '$title', '$message', '$link')");

    // 3. บันทึกแจ้งเตือนชุดที่ 2 (เปลี่ยนจาก prepare มาเป็น query ตรงๆ)
    $db->query("INSERT INTO notifications (user_id, title, message, link) 
                VALUES (NULL, '$title', '$message', 'admin/status?status=pending')");

    go('recycle.php#recycle-form', 'ส่งคำ');
}

// ดึงยอดรวม CO2 เปลี่ยนมาใช้ query แบบสั้น
$year = (int) date('Y');
$saved = $db->query("SELECT COALESCE(SUM(co2_kg), 0) As total FROM recycles WHERE user_id = $uId AND status = 'done' AND YEAR(created_at) = $year")->fetch_assoc()['total'] ?? null;