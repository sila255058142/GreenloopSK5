<?php
require_once __DIR__ . '/../init.php';
$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน' , 'warning');
if  ($admin['role'] !== 'admin') go('../index.php' , 'สำหรับแอดมิน' , 'danger');


// ดึงน้ำหนักรีไซเคิลและปริมาณ CO2 รวมจากรายการที่สำเร็จ
$sum = $db->query("SELECT COALESCE(SUM(weight_kg), 0) As kg , COALESCE(SUM(co2_kg), 0) AS co2 FROM recycles WHERE STATUS = 'done'")->fetch_assoc();
// ดึงยอด CO2 ที่ลดได้ แยกตามเดือนจากรายการรีไซเคิลที่สำเร็จ
$byMonth = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') As m, SUM(co2_kg)AS v FROM recycles WHERE status = 'done' GROUP BY m ORDER BY m")->fetch_all(MYSQLI_ASSOC);

// นับจำนวนสมาชิกทั่วไป
$memberCount = ($db->query("SELECT COUNT(*)
FROM users WHERE role = 'user'")->fetch_row() ?? [])[0] ?? null;

// นับจำนวนคำขอรีไซเคิลที่รอตรวจสอบ
$pendingRecycleCount = ($db->query("SELECT COUNT(*) FROM recycles WHERE status = 'pending'")->fetch_row() ?? [])[0] ?? null;
// นับจำนวนบัญชีที่มีสถานะ pending
$suspendedCount = ($db->query("SELECT COUNT(*) FROM users WHERE status = 'pending'")->fetch_row() ?? [])[0] ?? null;
// นับจำนวนคำขอแลกของรางวัลที่รออนุมัติ
$pendingcouponCount = ($db->query("SELECT COUNT(*) FROM coupon_redemptions WHERE status = 'pending'")->fetch_row() ?? [])[0] ?? null;
// นับการแจ้งเตือนส่วนกลางที่ยังไม่อ่าน
$unreadNotificationCount = ($db->query("SELECT COUNT(*) FROM notifications WHERE user_id IS NULL AND title = 'สมาชิกใหม่' AND is_read = 0")->fetch_row() ?? [])[0] ?? null;