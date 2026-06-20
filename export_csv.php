<?php

require "db.php";

if(!isset($_GET['id']))
{
    die("Activity not found");
}

$activityId = $_GET['id'];

$activity = $db->prepare("
SELECT *
FROM activities
WHERE id = ?
");

$activity->execute([$activityId]);

$activityData = $activity->fetch(PDO::FETCH_ASSOC);

if(!$activityData)
{
    die("Activity not found");
}

$records = $db->prepare("
SELECT *
FROM attendance
WHERE activity_id = ?
ORDER BY fullname ASC
");

$records->execute([$activityId]);

header('Content-Type: text/csv');
header(
    'Content-Disposition: attachment; filename="' .
    preg_replace('/[^A-Za-z0-9_-]/', '_', $activityData['name']) .
    '_attendance.csv"'
);

$output = fopen("php://output", "w");

fputcsv($output, [
    'INB Number',
    'Full Name',
    'Cluster',
    'Date',
    'Time In',
    'Time Out'
]);

while($row = $records->fetch(PDO::FETCH_ASSOC))
{
    fputcsv($output, [

        $row['inb_number'],
        $row['fullname'],
        $row['cluster'],
        $row['attendance_date'],

        !empty($row['time_in'])
            ? date("h:i A", strtotime($row['time_in']))
            : '',

        !empty($row['time_out'])
            ? date("h:i A", strtotime($row['time_out']))
            : ''

    ]);
}

fclose($output);
exit;
