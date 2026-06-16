<?php

session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if(
    $email === 'admin@iskolar.com' &&
    $password === 'admin123'
){
    $_SESSION['logged_in'] = true;

    header("Location: dashboard.php");
    exit;
}

header("Location: index.php");
exit;