<?php
require_once __DIR__ . '/../init.php';
$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน' , 'warning');
if  ($admin['role'] !== 'admin') go('../index.php' , 'สำหรับแอดมิน' , 'danger');

if(isset($_POST['delete'])){
    $id = (int) ($_POST['id']?? 0);
    if( $id > 0 && $id !== (int) $admin['id']){
        $db->query("DELETE FROM users WHERE id = $id AND role = 'user'");

    }
        go('users.php' , 'ลบ');
}
 if (isset($_POST['toggle_status'])){
      $id = (int) ($_POST['id']?? 0);
      if( $id > 0 && $id !== (int) $admin['id']){
        $db->query("UPDATE users SET status = IF(status = 'active' , 'suspended' , 'active') WHERE id = $id AND role = 'user'");

    }
    go('users.php' , 'อัพเดท');
 }
 if(isset($_POST['save_user'])){
    $id = trim($_POST['id']?? '');
    $name = trim($_POST['name']?? '');
    $email = trim($_POST['email']?? '');
    $phone = trim($_POST['phone']?? '');
    $password = trim($_POST['password']?? '');
    $status = in_array($_POST['status'] ?? 'active' ,['active' , 'suspended'] , true) ? $_POST['status'] : 'active';
    $points = max(0 , (int) ($_POST['id']?? ''));
    $question = 'ชื่อสัตวืเลี้ยงตัวแรก';
    $answer = password_hash('greenloop' , PASSWORD_DEFAULT);

    if($id === ''){
        $passhash = password_hash('password' , PASSWORD_DEFAULT);
        $db->query("INSERT INTO users (name, email, phone, password, question,answer,role,status,points) VALUES ('$name' , '$email' , ' $phone' , '$passhash' , ' $question' , '$answer' , 'user' , '$status' , ' $points')");

        go('users.php' , 'เพ่ิม');
    }
    $db->query("UPDATE users SET name = '$name' , email = '$email' , phone = ' $phone' , points = '$points' ,status = '$status' WHERE id = $id AND role = 'user'");
      go('users.php' , 'บันทึก');
 }

 $search = trim($_GET['q'] ?? '');
 $rows = $db->query("SELECT * FROM users WHERE role = 'user' AND(name like '%$search%' OR email like '%$search%' OR phone like '%$search%' ) ORDER BY id desc")->fetch_all(MYSQLI_ASSOC);