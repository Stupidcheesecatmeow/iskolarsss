<?php

require "db.php";

$activityId = $_POST['activity_id'];
$qrData = trim($_POST['qr_data']);

$data = explode("_", $qrData);

if(count($data) < 3)
{
    die("Invalid QR");
}

$fullname = trim($data[0]);
$inbNumber = trim($data[1]);
$cluster = trim($data[2]);

$date = date("Y-m-d");
$time = date("H:i:s");

$check = $db->prepare("
SELECT *
FROM attendance
WHERE activity_id = ?
AND inb_number = ?
AND attendance_date = ?
LIMIT 1
");

$check->execute([
    $activityId,
    $inbNumber,
    $date
]);

$record = $check->fetch(PDO::FETCH_ASSOC);

if(!$record)
{
    $stmt = $db->prepare("
    INSERT INTO attendance(
        activity_id,
        fullname,
        inb_number,
        cluster,
        attendance_date,
        time_in,
        time_out
    )
    VALUES(?,?,?,?,?,?,?)
    ");

    $stmt->execute([
        $activityId,
        $fullname,
        $inbNumber,
        $cluster,
        $date,
        $time,
        null
    ]);

    die('TIME IN RECORDED');
}

if(empty($record['time_out']))
{
    $update = $db->prepare("
    UPDATE attendance
    SET time_out = ?
    WHERE id = ?
    ");

    $update->execute([
        $time,
        $record['id']
    ]);

    die('TIME OUT RECORDED');
}

die('ALREADY TIMED OUT');