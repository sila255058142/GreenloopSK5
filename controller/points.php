<?php
require_once __DIR__ . '/../init.php';

$u = me();
if(!$u) go('login.php' , 'เข้าสู่ระบบ' , 'warning');

$uId = (int) $u['id'];

// ดึงจำนวนรายการรีไซเคิลสำเร็จและ CO2 ที่สมาชิกลดได้
$sum = $db->query("SELECT COUNT(*) As n , COALESCE(sum(co2_kg), 0) AS co2 FROM recycles WHERE status = 'done' AND user_id = $uId")->fetch_assoc();
// ดึงสมาชิกที่ใช้งานอยู่ 5 อันดับแรกตามแต้ม
$top = ($db->query("SELECT id , name,points FROM users WHERE role = 'user' AND status = 'active' ORDER BY points DESC LIMIT 5"))->fetch_all(MYSQLI_ASSOC);
