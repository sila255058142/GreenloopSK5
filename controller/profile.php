<?php
$u = me();
if(!$u) go('login.php' , 'เข้าสู่ระบบ' , 'warning');

if(isset($_POST['save'])){
    $name = trim($_POST['name']?? '');
    $email = trim($_POST['email']?? '');
    $phone = trim($_POST['phone']?? '');
    $userId = (int) $u['id'];

    // อัปเดตชื่อ อีเมล และเบอร์โทรของสมาชิกปัจจุบัน
    $db->query("UPDATE users SET name ='$name' , email='$email', phone ='$phone' WHERE id = $userId");

    $_SESSION['user']['name'] = $_SESSION['name'] = $name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['phone'] = $phone;
    go('profile.php', 'บันทึกโปรไฟล์');
}
if(isset($_POST['change'])){
    $uId = (int)$u['id'];
    $pass1 = trim($_POST['password'] ?? '');

    $newHash = password_hash($pass1 , PASSWORD_DEFAULT);
    // เปลี่ยนรหัสผ่านของสมาชิกปัจจุบัน
    $db->query("UPDATE users SET password = '$newHash' WHERE id = '$uId'");
     go('profile.php', 'เปลี่ยนรหัส');
}
