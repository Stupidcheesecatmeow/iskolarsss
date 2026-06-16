<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    header("Location: index.php");
    exit;
}

require "db.php";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $name = trim($_POST['activity_name']);

    if(!empty($name))
    {
        $stmt = $db->prepare("
        INSERT INTO activities(name)
        VALUES(?)
        ");

        $stmt->execute([$name]);
    }
}

header("Location: index.php");
exit;