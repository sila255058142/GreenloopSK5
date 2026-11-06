<?php
require_once __DIR__ . '/../init.php';

$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน', 'warning');
if ($admin['role'] !== 'admin') go('../index.php', 'สำหรับแอดมิน', 'danger');

$db->query("UPDATE notifications SET is_read = 1 WHERE user_id IS NULL AND title = 'สมาชิกใหม่' AND is_read = 0");
$rows = $db->query("SELECT title, message, created_at FROM notifications WHERE user_id IS NULL AND title = 'สมาชิกใหม่' ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
