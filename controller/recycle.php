<?php
require_once __DIR__ . '/../init.php';

$u = me();
if(!$u) go('login.php' , 'เข้าสู่ระบบ' , 'warning');


// ดึงหมวดรีไซเคิลทั้งหมดพร้อมอัตราลด CO2 เพื่อแสดงในฟอร์ม
$cats = ($db->query('SELECT * FROM categories ORDER BY id'))->fetch_all(MYSQLI_ASSOC);
$uId = (int) $u['id'];

if($_POST){
    $cateId = (int) ($_POST['category_id'] ?? 0);
    
    // ดึงข้อมูลหมวดที่เลือกเพื่อนำอัตราลด CO2 ไปใช้ภายหลัง
    $cate = $db->query("SELECT * FROM categories WHERE id = $cateId")->fetch_assoc();

    $itemName = trim($_POST['item_name'] ?? '');
    $weight = trim($_POST['weight_kg'] ?? 0);
    $deli = trim($_POST['delivery_type'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (mb_strlen($itemName) < 3 || $weight <= 0 || !$cate || !in_array($deli, ['self', 'pickup'], true)){
        go('recycle.php', 'ตรวจสอบข้อมูล', 'danger');
    }

    $image = upload('image');
    if ($image === false) go('recycle.php', 'อัปโหลดรูปไม่สำเร็จ กรุณาลองใหม่', 'danger');

    // เพิ่มคำขอรีไซเคิลของสมาชิก พร้อมข้อมูลสิ่งของ น้ำหนัก รูป และการขนส่ง
    $db->query("INSERT INTO recycles (user_id, category_id, item_name, weight_kg, image, delivery_type, address) 
                VALUES ($uId, $cateId, '$itemName', $weight, '$image', '$deli', '$address')");

    go('recycle.php#recycle-form', 'ส่งคำ');
}

// ดึงยอดรวม CO2 เปลี่ยนมาใช้ query แบบสั้น
$year = (int) date('Y');
// รวม CO2 ที่สมาชิกคนนี้ลดได้จากรายการสำเร็จในปีปัจจุบัน
$saved = $db->query("SELECT COALESCE(SUM(co2_kg), 0) As total
 FROM recycles WHERE user_id = $uId 
 AND status = 'done' 
 AND YEAR(created_at) = $year"
 )->fetch_assoc()['total'] ?? null;