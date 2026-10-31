<?php

session_start();

require_once __DIR__ . '/conn/db.php';

function me(){
    return !empty($_SESSION['uid']) ? ($_SESSION['user'] ?? null) : null;
}
function e($value){
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
function go($url ,$msg = '',$type = 'success' ){
if($msg){
    $_SESSION['flash'] = [$msg,$type];
}
    header("Location: $url");
    exit;
}


function upload($field){
    $file = $_FILES[$field] ?? null;
    if (!$file || empty($file['name']) || $file['error'] !== UPLOAD_ERR_OK){
        return false;
    }
    $ext = strtolower(pathinfo($file['name'] , PATHINFO_EXTENSION));
    $name = uniqid() . '.' . $ext;
    return move_uploaded_file($file['tmp_name'] , __DIR__ . "/upload/$name")
? $name : false;


}
require_once __DIR__ . '/header.php';