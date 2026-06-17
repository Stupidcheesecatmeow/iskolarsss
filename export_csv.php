<?php

require "db.php";

if(!isset($_GET['id']))
{
    die("Activity not found");
}

$activityId = $_GET['id'];

$stmt = $db->prepare("
SELECT name
FROM activities
WHERE id = ?
");

$stmt->execute([$activityId]);

$activity = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$activity)
{
    die("Activity not found");
}

$records = $db->prepare("
SELECT *
FROM attendance
WHERE activity_id = ?
ORDER BY id ASC
");

$records->execute([$activityId]);

$attendance = $records->fetchAll(PDO::FETCH_ASSOC);

$filename =
preg_replace(
'/[^A-Za-z0-9\-]/',
'_',
$activity['name']
);

header('Content-Type: text/csv');
header(
'Content-Disposition: attachment; filename="' .
$filename .
'_attendance.csv"'
);

$output = fopen('php://output', 'w');

fputcsv($output, [

    'INB Number',
    'Full Name',
    'Cluster',
    'Date',
    'Time'

]);

foreach($attendance as $row)
{
    fputcsv($output, [

        $row['inb_number'],
        $row['fullname'],
        $row['cluster'],
        $row['attendance_date'],
        $row['attendance_time']

    ]);
}

fclose($output);
exit;
?>
