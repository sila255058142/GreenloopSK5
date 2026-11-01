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
    if (!$file || empty($file['tmp_name'])){
        return '';
    }
    $image = getimagesize($file['tmp_name']);
    if (!$image){
        return '';
    }

    $directory = __DIR__ . '/uploads';
    if (!is_dir($directory)) mkdir($directory, 0755, true);
    $name = uniqid() . image_type_to_extension($image[2], true);
    return move_uploaded_file($file['tmp_name'], $directory . '/' . $name) ? $name : false;
}
require_once __DIR__ . '/header.php';