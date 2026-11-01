<?php
require_once __DIR__ . '/../init.php';
$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน' , 'warning');
if  ($admin['role'] !== 'admin') go('../index.php' , 'สำหรับแอดมิน' , 'danger');

if (isset($_POST['toggle_status'])) {
    $id = (int) ($_POST['id'] ?? 0);
    if ($id > 0) {
        $db->query("UPDATE users SET status = IF(status = 'active', 'suspended', 'active') WHERE id = $id AND role = 'user'");
    }
    go('users.php', 'อัพเดท');
}

$rows = $db->query("SELECT * FROM users WHERE role = 'user' ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);