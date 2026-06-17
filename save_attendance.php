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
");

$check->execute([
    $activityId,
    $inbNumber
]);

if($check->fetch())
{
    die("Already Recorded");
}

$stmt = $db->prepare("
INSERT INTO attendance(

    activity_id,
    fullname,
    inb_number,
    cluster,
    attendance_date,
    attendance_time

)

VALUES(?,?,?,?,?,?)
");

$stmt->execute([

    $activityId,
    $fullname,
    $inbNumber,
    $cluster,
    $date,
    $time

]);

echo "Attendance Saved";