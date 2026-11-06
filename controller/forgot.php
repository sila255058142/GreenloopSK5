<?php
require_once __DIR__ . '/../init.php';

if ($_POST) {
    $email = $db->real_escape_string($_POST['email'] ?? '');
    $u = $db->query("SELECT id, question, answer FROM users WHERE email = '$email'")->fetch_assoc();

    if (!$u || $u['question'] !== trim($_POST['question'] ?? '') || !password_verify(trim($_POST['answer'] ?? ''), $u['answer'])) {
        go('forgot.php', 'อีเมล คำถาม คำตอบไม่ถูก', 'danger');
    }

    $pass1 = trim($_POST['password'] ?? '');
    $pass2 = trim($_POST['password2'] ?? '');
    if ($pass1 !== $pass2) go('forgot.php', 'รหัสผ่านไม่ตรง');

    $newHash = $db->real_escape_string(password_hash($pass1, PASSWORD_DEFAULT));
    $db->query("UPDATE users SET password = '$newHash' WHERE id = " . (int) $u['id']);

    go('login.php', 'สำเร็จ');
}