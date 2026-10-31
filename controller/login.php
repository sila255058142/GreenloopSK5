<?php
require_once __DIR__ . '/../init.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$u = $db->query("SELECT * FROM users WHERE email = '$email'")->fetch_assoc();

$passM = $u && password_verify($password, $u['password']);
$lpassM = $u && hash_equals($u['password'], md5($password));

if (!$u || (!$passM && !$lpassM)) {
    go('../login.php' ,'รหัสไม่ถูกต้อง' ,'danger');
}

if ($lpassM) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $userId = (int) $u['id'];
    $db->query("UPDATE users SET password = '$hash' WHERE id = $userId");
}

session_regenerate_id(true);
$_SESSION['uid'] = $_SESSION['user_id'] = $u['id'];
$_SESSION['name'] = $u['name'];
$_SESSION['role'] = $u['role'];
unset($u['password'], $u['answer']);
$_SESSION['user'] = $u;

go($u['role'] === 'admin' ? '../admin/index.php' : '../index.php' ,'เข้าสู่ระบบสำเร็จ');