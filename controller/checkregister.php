<?php
require_once __DIR__ . '/../init.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';
$question = $_POST['question'] ?? '';
$answer = trim($_POST['answer'] ?? '');

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$answerHash = password_hash($answer, PASSWORD_DEFAULT);

$db->query("INSERT INTO users (name, email, phone, password, question, answer) 
            VALUES ('$name', '$email', '$phone', '$passwordHash', '$question', '$answerHash')");

go('../login.php' , 'สมัครสมาชิกสำเร็จ' );