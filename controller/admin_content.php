<?php
require_once __DIR__ . '/../init.php';
$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน' , 'warning');
if ($admin['role'] !== 'admin') go('../index.php' , 'สำหรับแอดมิน' , 'danger');

// 1. ส่วนลบข้อมูล (เปลี่ยนเป็น query)
if(isset($_POST['delete'])){
    $id = trim($_POST['id'] ?? '');
    $db->query("DELETE FROM contents WHERE id = $id");
    go('content.php' , 'ลบเนื้อหา');
}

// 2. ส่วนแก้ไข (อันนี้เดิมใช้ query อยู่แล้ว แต่ปรับตัวแปรให้ตรงกัน)
if(isset($_POST['edit'])){
    echo 2;   
    $title = trim($_POST['title']?? '');
    $body = trim($_POST['body']?? '');
    $startAt = trim($_POST['start_at']?? '');
    $endAt = trim($_POST['end_at']?? '');
    $id = $_POST['Id'] ?? '';

    $db->query("UPDATE `contents` SET `title` = '$title', `body` = '$body', `start_at` = '$startAt', `end_at` = '$endAt` WHERE `contents`.`id` = $id");
}

// 3. ส่วนบันทึก/อัปเดตหลัก (เปลี่ยนจาก prepare เป็น query รวบยอด)
if($_POST && !isset($_POST['delete']) && !isset($_POST['edit'])){
    $title = trim($_POST['title']?? '');
    $body = trim($_POST['body']?? '');
    $startAt = trim($_POST['start_at']?? '');
    $endAt = trim($_POST['end_at']?? '');
    $id = trim($_POST['id']?? '');

    $endAt = $endAt !== '' ? "'$endAt'" : "NULL";
    $rId = $id !== '' ? $id : $admin['id'];

    if ($id !== '') {
        // อัปเดตข้อมูล
        $db->query("UPDATE contents SET title = '$title', body = '$body', start_at = '$startAt', end_at = $endAt WHERE id = $id");
    } else {
        // เพิ่มข้อมูลใหม่
        $db->query("INSERT INTO contents (title, body, start_at, end_at, user_id) VALUES ('$title', '$body', '$startAt', $endAt, $rId)");
    }
    go('content.php' , 'บันทึก');
}

// 4. ส่วนดึงข้อมูลมาแก้ (เปลี่ยนเป็น query)
$editId = trim($_GET['edit'] ?? '');
$editResult = $editId !== '' ? $db->query("SELECT * FROM contents WHERE id = $editId") : null;
$edit = ($editResult && $editResult->num_rows > 0) ? $editResult->fetch_assoc() : [
    'id' => '',
    'title' => '',
    'body' => '',
    'start_at' => date('Y-m-d H:i'),
    'end_at' => ''
];

// 5. ส่วนค้นหาข้อมูล (เปลี่ยนเป็น query)
$s = trim($_GET['q'] ?? '');
$rows = $db->query("SELECT *, IF(start_at > NOW(), 'รอเผยแพร่', IF(end_at <= NOW(), 'หมดเวลา', 'กำลังแสดง')) AS Live 
                    FROM contents 
                    WHERE title LIKE '%$s%' OR body LIKE '%$s%' 
                    ORDER BY start_at DESC")->fetch_all(MYSQLI_ASSOC);

$local = function ($s){ 
    return $s ? date('Y-m-d H:i' , strtotime($s)) : '';
};
?>