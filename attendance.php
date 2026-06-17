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

    ?>

    <!DOCTYPE html>
    <html>
    <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($activity['name']) ?></title>

    <script src="https://unpkg.com/html5-qrcode"></script>

    </head>

    <body>

    <h1><?= htmlspecialchars($activity['name']) ?></h1>

    <div id="reader" style="width:500px"></div>

    <h2>Attendance Records</h2>

    <table border="1" cellpadding="10">

    <tr>
        <th>INB</th>
        <th>Name</th>
        <th>Cluster</th>
        <th>Date</th>
        <th>Time</th>
    </tr>

    <?php foreach($attendance as $row): ?>

    <tr>

    <td><?= htmlspecialchars($row['inb_number']) ?></td>
    <td><?= htmlspecialchars($row['fullname']) ?></td>
    <td><?= htmlspecialchars($row['cluster']) ?></td>
    <td><?= htmlspecialchars($row['attendance_date']) ?></td>
    <td><?= htmlspecialchars($row['attendance_time']) ?></td>

    </tr>

    <?php endforeach; ?>

    </table>

    <script>

    function onScanSuccess(decodedText)
    {

        fetch("save_attendance.php", {

            method:"POST",

            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },

            body:
            "activity_id=<?= $activityId ?>&qr_data="
            + encodeURIComponent(decodedText)

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

    </script>

    </body>
    </html>