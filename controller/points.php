<?php
require_once __DIR__ . '/../init.php';

$u = me();
if(!$u) go('login.php' , 'เข้าสู่ระบบ' , 'warning');

$sum = $db->query("SELECT COUNT(*) As n , COALESCE(sum(co2_kg), 0) AS co2 FROM recycles WHERE status = 'done' AND user_id = {$u['id']}")->fetch_assoc();
$top = ($db->query("SELECT id , name,points FROM users WHERE role = 'user' AND status = 'active' ORDER BY points DESC LIMIT 5"))->fetch_all(MYSQLI_ASSOC);

