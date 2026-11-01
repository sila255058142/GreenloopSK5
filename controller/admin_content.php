<?php
require_once __DIR__ . '/../init.php';
$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน' , 'warning');
if ($admin['role'] !== 'admin') go('../index.php' , 'สำหรับแอดมิน' , 'danger');

if (isset($_POST['delete'])) {
    $id = trim($_POST['id'] ?? '');
    // ลบเนื้อหาตาม ID ที่เลือก
    $db->query("DELETE FROM contents WHERE id = $id");
    go('content.php', 'ลบเนื้อหา');
}

if ($_POST) {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    $startAt = trim($_POST['start_at'] ?? '');
    $endAt = trim($_POST['end_at'] ?? '');
    $id = trim($_POST['id'] ?? '');

    if ($id !== '') {
        $db->query("UPDATE contents SET title = '$title', body = '$body', start_at = '$startAt', end_at = '$endAt' WHERE id = $id");
    } else {
        $db->query("INSERT INTO contents (title, body, start_at, end_at, user_id) VALUES ('$title', '$body', '$startAt', '$endAt', {$admin['id']})");
    }
    go('content.php', 'บันทึก');
}

// ค่าเริ่มต้นสำหรับฟอร์มเพิ่มเนื้อหา; หน้าแก้ไขดึงข้อมูลแยกอยู่แล้ว
$edit = [
    'id' => '',
    'title' => '',
    'body' => '',
    'start_at' => date('Y-m-d H:i'),
    'end_at' => ''
];

$s = trim($_GET['q'] ?? '');
// ค้นหาเนื้อหาตามหัวข้อหรือข้อความ พร้อมคำนวณสถานะการเผยแพร่และเรียงตามวันเริ่ม
$rows = $db->query("SELECT *, IF(start_at > NOW(), 'รอเผยแพร่', IF(end_at <= NOW(), 'หมดเวลา', 'กำลังแสดง')) AS Live 
                    FROM contents 
                    WHERE title LIKE '%$s%' OR body LIKE '%$s%' 
                    ORDER BY start_at DESC")->fetch_all(MYSQLI_ASSOC);

$local = function ($s){ 
    return $s ? date('Y-m-d H:i' , strtotime($s)) : '';
};
?>