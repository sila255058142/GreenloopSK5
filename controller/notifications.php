<?php
require_once __DIR__ . '/../init.php';

$u = me();
if ($u && $u['role'] === 'admin') {
    go('../admin/index.php');
}
$inboxUserId = $u['role'] === 'admin' ? null : $u['id'];
if($_POST){
    $id = trim($_POST['id']?? '');
    $db->query("DELETE FROM notifications WHERE id = '$id' AND user_id <=> '$inboxUserId' ");
    go('notifications.php' , 'ลบ');
}
$q = trim($_GET['q'] ?? '');
$rows = $db->query("SELECT * FROM notifications WHERE user_id <=> '$inboxUserId' AND (title LIKE '%$q %' OR message LIKE '%$q %') ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);

$db->query("UPDATE notifications SET is_read = 1 WHERE user_id <=> '$inboxUserId'");