<?php
require_once __DIR__ . '/../init.php';
$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน' , 'warning');
if  ($admin['role'] !== 'admin') go('../index.php' , 'สำหรับแอดมิน' , 'danger');

if(isset($_POST['del_category'])){
    // ลบหมวดรีไซเคิลตาม ID ที่เลือก
    $db->query("DELETE FROM categories WHERE id = {$_POST['id']}");
    go('green.php' , 'ลบสำเร็จ');
}

if(isset($_POST['save_category'])){
    $id = $_POST['id']?? '';
    // แก้ไขหมวดเดิมหรือเพิ่มหมวดใหม่พร้อมอัตราลด CO2 ต่อกิโลกรัม
    $db->query($id
        ? "UPDATE categories SET name = '{$_POST['name']}', co2_per_kg = '{$_POST['co2_per_kg']}' WHERE id = '$id'"
        : "INSERT INTO categories(name, co2_per_kg) VALUES ('{$_POST['name']}', '{$_POST['co2_per_kg']}')");
     go('green.php' , 'บันทึก');

}
// ดึงหมวดรีไซเคิลทั้งหมดเรียงตาม ID เพื่อแสดงและแก้ไข
$cats = $db->query("SELECT * FROM categories ORDER BY id")->fetch_all(MYSQLI_ASSOC);
$cats[] = ['id' => '', 'name' => '', 'co2_per_kg' => ''];