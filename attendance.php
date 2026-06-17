<?php

require "db.php";

if(!isset($_GET['id']))
{
    die("Activity not found");
}

$activityId = $_GET['id'];

$stmt = $db->prepare("
SELECT *
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
ORDER BY id DESC
");

$records->execute([$activityId]);

$attendance = $records->fetchAll(PDO::FETCH_ASSOC);

$totalAttendance = count($attendance);

?>

<!DOCTYPE html>

<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($activity['name']) ?></title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="styles/attendance.css">

<script src="https://unpkg.com/html5-qrcode"></script>

</head>

<body>

<header class="topbar">

```
<div class="brand">
    <?= htmlspecialchars($activity['name']) ?>
</div>

<a href="activity.php" class="back-btn">
    ← Back
</a>
```

</header>

<div class="container">

```
<div class="stats">

    <div class="card total-card">

        <h1><?= $totalAttendance ?></h1>

        <p>Total Attendance</p>

    </div>

    <div class="card">

        <h2>QR Scanner</h2>

        <div id="reader"></div>

    </div>

</div>

<div class="actions">

    <a
        href="export_csv.php?id=<?= $activityId ?>"
        class="export-btn"
    >
        Export CSV
    </a>

</div>

<div class="card">

    <h2>Attendance Records</h2>

    <div class="search-box">

        <input
            type="text"
            id="searchInput"
            placeholder="Search INB Number..."
        >

    </div>

    <div class="table-wrapper">

        <table id="attendanceTable">

            <thead>

                <tr>
                    <th>INB NO.</th>
                    <th>NAME</th>
                    <th>CLUSTER</th>
                    <th>DATE</th>
                    <th>TIME</th>
                </tr>

            </thead>

            <tbody>

            <?php foreach($attendance as $row): ?>

                <tr>

                    <td><?= htmlspecialchars($row['inb_number']) ?></td>

                    <td><?= htmlspecialchars($row['fullname']) ?></td>

                    <td><?= htmlspecialchars($row['cluster']) ?></td>

                    <td><?= htmlspecialchars($row['attendance_date']) ?></td>

                    <td><?= htmlspecialchars($row['attendance_time']) ?></td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>
```

</div>

<script>

function onScanSuccess(decodedText)
{
    fetch("save_attendance.php", {

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:
        "activity_id=<?= $activityId ?>&qr_data=" +
        encodeURIComponent(decodedText)

    })
    .then(res => res.text())
    .then(data => {

        alert(data);

        location.reload();

    });
}

new Html5QrcodeScanner(
    "reader",
    {
        fps:10,
        qrbox:250
    }
).render(onScanSuccess);

const searchInput =
document.getElementById("searchInput");

searchInput.addEventListener("keyup", function(){

    let filter =
    this.value.toUpperCase();

    let rows =
    document.querySelectorAll(
    "#attendanceTable tbody tr"
    );

    rows.forEach(row => {

        let inb =
        row.cells[0].textContent;

        if(
            inb.toUpperCase()
            .includes(filter)
        ){
            row.style.display = "";
        }
        else{
            row.style.display = "none";
        }

    });

});

</script>

</body>
</html>
