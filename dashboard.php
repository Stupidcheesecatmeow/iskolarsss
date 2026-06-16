<?php

session_start();

if(!isset($_SESSION['logged_in']))
{
    header("Location: index.php");
    exit;
}

require "db.php";

$activities = $db->query("
SELECT *
FROM activities
ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<div class="container">

    <div class="left">

        <img src="assets/logo.png" alt="logo" class="logo">

        <h1 class="title">
            Attendance Management
        </h1>

        <form action="create_activity.php" method="POST">

            <label>Activity Name</label>

            <input
                type="text"
                name="activity_name"
                placeholder="Enter activity name"
                required
            >

            <button type="submit" class="create-btn">
                Create Activity
            </button>

        </form>

        <div class="activities">

            <h3>Activities</h3>

            <?php if(count($activities) > 0): ?>

                <?php foreach($activities as $activity): ?>

                    <div class="activity-card">

                        <div>
                            <strong>
                                <?= htmlspecialchars($activity['name']) ?>
                            </strong>
                        </div>

                        <a
                            href="activity.php?id=<?= $activity['id'] ?>"
                            class="open-btn"
                        >
                            Open
                        </a>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p>No activities yet.</p>

            <?php endif; ?>

        </div>

        <br>

        <a href="logout.php" class="open-btn">
            Logout
        </a>

    </div>

    <div class="right">

        <div class="overlay">

            <img
                src="assets/logo.png"
                alt="logo"
                class="big-logo"
            >

        </div>

    </div>

</div>

</body>
</html>