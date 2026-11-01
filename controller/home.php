<?php


require_once __DIR__ . '/../init.php';

$u = me();
if ($u && $u['role'] === 'admin') {
    go('../admin/index.php');
}

// ดึงเนื้อหาที่อยู่ในช่วงเวลาเผยแพร่ เรียงเนื้อหาใหม่ก่อน
$new = $db->query('SELECT * FROM contents WHERE start_at <= NOW() AND (end_at IS NULL OR end_at > NOW()) ORDER BY start_at DESC')->fetch_all(MYSQLI_ASSOC);
$FN = $new ? array_shift($new) : null ;
// รวมจำนวนรายการ น้ำหนัก และ CO2 ของรายการรีไซเคิลที่สำเร็จ
$sum = $db->query("SELECT COUNT(*) AS n , COALESCE(SUM(weight_kg), 0) AS kg , COALESCE(SUM(co2_kg), 0) AS co2 FROM recycles WHERE status = 'done'")->fetch_assoc();
// นับจำนวนสมาชิกทั่วไป
$MC = (int) $db->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetch_row()[0];

// print_r($new); exit;