<?php
require_once __DIR__ . '/../init.php';

$u = me();
if (!$u) go('login.php', 'เข้าสู่ระบบ', 'warning');
if ($u['role'] === 'admin') {
    go('../admin/index.php');
}
$inboxUserId = (int) $u['id'];
if($_POST){
    $id = (int) ($_POST['id'] ?? 0);
    // ลบการแจ้งเตือนเฉพาะรายการที่เป็นของสมาชิกที่ล็อกอินอยู่
    $db->query("DELETE FROM notifications WHERE id = $id AND user_id = $inboxUserId");
    go('notifications.php' , 'ลบ');
}
$q = trim($_GET['q'] ?? '');
$q = $db->real_escape_string($q);
// ค้นหาการแจ้งเตือนของสมาชิกตามหัวข้อหรือข้อความ เรียงรายการใหม่ก่อน
$rows = $db->query("SELECT * FROM notifications 
WHERE user_id = $inboxUserId 
AND (title LIKE '%$q%'
OR message LIKE '%$q%')
ORDER BY id DESC"
)->fetch_all(MYSQLI_ASSOC);

// ทำเครื่องหมายการแจ้งเตือนทั้งหมดของสมาชิกว่าอ่านแล้ว
$db->query("UPDATE notifications SET is_read = 1 WHERE user_id = $inboxUserId");