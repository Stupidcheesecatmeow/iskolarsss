<?php

session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(
    $email === '    ' &&
    $password === 'admin123'
){
    $_SESSION['logged_in'] = true;

    header("Location: dashboard.php");
    exit;
}

header("Location: index.php");
exit;