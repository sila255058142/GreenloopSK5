<?php
// require_once __DIR__ . '/../init.php';

$u = me();
if(!$u) go('login.php' , 'เข้าสู่ระบบ' , 'warning');

if(isset($_POST['save'])){
    $name = trim($_POST['name']?? '');
    $email = trim($_POST['email']?? '');
    $phone = trim($_POST['phone']?? '');
    $userId = (int) $u['id'];

    $db->query("UPDATE users SET name ='$name' , email='$email', phone ='$phone' WHERE id = $userId");

    $_SESSION['user']['name'] = $name;
    go('profile.php', 'บันทึกโปรไฟล์');
}
if(isset($_POST['change'])){
    $uId = (int)$u['id'];
    $pass1 = trim($_POST['password'] ?? '');

    $newHash = password_hash($pass1 , PASSWORD_DEFAULT);
    $db->query("UPDATE users SET password = '$newHash' WHERE id = '$uId'");
     go('profile.php', 'เปลี่ยนรหัส');
}
