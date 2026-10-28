<?php


require_once __DIR__ . '/bootstrap.php';

$u = me();
if ($u && $u['role'] === 'admin') {
    go('../admin/indexs.php');
}