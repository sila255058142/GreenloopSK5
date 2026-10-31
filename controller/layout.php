<?php
function notifications_count(){
    global $db;
    $u = me();
    if(!$u) return 0;
    $uId = $u['role']=== 'admin' ? 'NULL' : $u['id'];
    
    $res = $db->query("SELECT COUNT(*) FROM notifications WHERE is_read = 0 AND user_id <=> $uId");
    return $res ? (int) $res->fetch_row()[0]: 0;
    }