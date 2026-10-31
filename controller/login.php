<?php
require_once __DIR__ . '/../init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$u = $stmt->get_result()->fetch_assoc();
$stmt->close();

$passM = $u && password_verify($password, $u['password']);
$lpassM = $u && hash_equals($u['password'], md5($password));

if (!$u || (!$passM && !$lpassM)) {
    go('../login.php' ,'รหัสไม่ถูกต้อง' ,'danger');
}

if ($lpassM) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
    $stmt->bind_param('si', $hash, $u['id']);
    $stmt->execute();
    $stmt->close();
}

session_regenerate_id(true);
$_SESSION['uid'] = $_SESSION['user_id'] = $u['id'];
$_SESSION['name'] = $u['name'];
$_SESSION['role'] = $u['role'];
unset($u['password'], $u['answer']);
$_SESSION['user'] = $u;

go($u['role'] === 'admin' ? '../admin/index.php' : '../index.php' ,'เข้าสู่ระบบสำเร็จ');
