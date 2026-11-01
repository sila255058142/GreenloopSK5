<?php

$u = me();
if(!$u) go('login.php' , 'เข้าสู่ระบบ' , 'warning');
$uId = $u['id'];

if(isset($_POST['redeem'])){
    $rewardId = $_POST['reward_id'] ?? 0;
    $reward = $db->query("SELECT * FROM rewards WHERE id = $rewardId AND is_active = 1")->fetch_assoc();

    if(!$reward) go('coupons.php' , 'ไม่พบ', 'danger');

    $cost = $reward['points_cost'];
    $db->query("UPDATE users SET points = points - $cost WHERE id = $uId");
    $db->query("UPDATE rewards SET stock = stock -1 WHERE id = $rewardId AND stock IS NOT NULL");
    $db->query("INSERT INTO coupon_redemptions (user_id, reward_id, points_spent) VALUES ($uId, $rewardId, $cost)");

    
    go('coupons.php' , 'ส่งคำขอแล้ว');
}

$rewards = $db->query('SELECT * from rewards WHERE is_active = 1')->fetch_all(MYSQLI_ASSOC);
$myCoupons = $db->query("SELECT r.title, cr.points_spent,cr.status,cr.created_at 
FROM coupon_redemptions cr JOIN rewards r ON r.id = cr.reward_id 
WHERE cr.user_id = ". (int) $uId ." ORDER BY cr.created_at DESC"
)->fetch_all(MYSQLI_ASSOC);
$balance = $db->query("SELECT points FROM users WHERE id = $uId")->fetch_row()[0] ?? 0;