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

if(isset($_POST['claim'])){
    $code = $_POST['coupon_code'] ?? '';
    $recipient = $_POST['recipient_name']?? '';
    $phone = $_POST['recipient_phone'] ?? '';
    $address = $_POST['shipping_address']?? '';

    $coupon = $db->query("SELECT id FROM coupon_redemptions WHERE coupon_code = '$code' AND user_id = $userId")->fetch_assoc();

if(!$coupon) go('coupons.php' , 'ไม่พบ', 'danger');

$db->query(" UPDATE coupon_redemptions SET status = 'used', used_at = NOW(), recipient_name = '$recipient ' , recipient_phone='$phone' , shipping_address = ' $address' ,WHERE coupon_code = '$code' AND user_id = '$uId'");
go('coupons.php' , 'ยืนยัน');
}
$rewards = $db->query('SELECT * from rewards WHERE is_active = 1')->fetch_all(MYSQLI_ASSOC);
$balance = $db->query("SELECT points FROM users WHERE id = $uId")->fetch_row()[0] ?? 0;
$myCoupons = $db->query("SELECT r.title, cr.points_spent,cr.status,cr.created_at FROM coupon_redemptions cr JOIN rewards r ON r.id = cr.reward_id WHERE cr.user_id = ". (int) $uId ." ORDER BY cr.created_at DESC")->fetch_all(MYSQLI_ASSOC);