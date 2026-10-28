<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/conn/db.php';

function me(){
    return !empty($_SESSION['uid']) ? ($_SESSION['user'] ?? null) : null;
}
function e($value){
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
function go($url){
    header("Location: $url");
    exit;
}
require_once __DIR__ . '/header.php';