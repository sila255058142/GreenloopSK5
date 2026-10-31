<?php
require_once __DIR__ . '/../init.php';
$admin = me();
if (!$admin) go('../login.php', 'กรุณาล็อกอิน' , 'warning');
if  ($admin['role'] !== 'admin') go('../index.php' , 'สำหรับแอดมิน' , 'danger');


if(isset($_POST['delete'])){
    $id = trim($_POST['id'] ?? '');
    $stmt = $db->prepare('DELETE FROM contents WHERE id = ?');
    $stmt->bind_param('s' , $id);
    $stmt->execute();
    go('content.php' , 'ลบเนื้อหา');
}

    if(isset($_POST['edit'])){
  echo 2;   
        $title = trim($_POST['title']?? '');
        $body = trim($_POST['body']?? '');
        $startAt = trim($_POST['start_at']?? '');
        $endAt = trim($_POST['end_at']?? '');
        $id = $_POST['Id'];

        $select = $db->query("UPDATE `contents` SET `title` = $title, `body` = $body, `start_at` = $startAt, `end_at` = $endAt WHERE `contents`.`id` = $id");

    }

if($_POST){
    $title = trim($_POST['title']?? '');
    $body = trim($_POST['body']?? '');
    $startAt = trim($_POST['start_at']?? '');
    $endAt = trim($_POST['end_at']?? '');
    $id = trim($_POST['id']?? '');


    $endAt = $endAt ?: null;
    $sql = $id !== '' ? 'UPDATE contents SET title = ?, body = ?, start_at = ?,end_at = ? WHERE id =?' : 'INSERT INTO contents (title,body,start_at,end_at,user_id) VALUES (?,?,?,?,?)';
    $rId = $id !== '' ? $id : $admin['id'];
    $stmt = $db->prepare($sql);
    $stmt->bind_param('sssss' , $title , $body ,$startAt,$endAt,$rId);
    $stmt->execute();
    go('content.php' , 'บันทึก');
}

$editId = TRIM($_get['edit']?? '');
$stmt = $db->prepare('SELECT * FROM contents WHERE id = ?');
$stmt->bind_param('s' , $editId);
$stmt->execute();
$edit = $stmt->get_result()->fetch_assoc() ?: [
    'id' => '',
    'title' => '',
    'body' => '',
    'start_at' => date('Y-m-d H:i'),
    'end_at' => ''
];

$s = '%' . trim($_GET['q']?? '') . '%';

$stmt = $db->prepare("SELECT * , IF(start_at > NOW(), 'รอเผยแพร่' , IF(end_at <= NOW(), 'หมดเวลา'  , 'กำลังแสดง')) AS Live FROM contents WHERE title LIKE ? OR body LIKE ? ORDER BY start_at DESC ");

$stmt->bind_param('ss', $s, $s,);
$stmt->execute();
$rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$local = function ($s){ return $s ? date('Y-m-d\H:i' , strtotime($s)): '';
}
?>