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

    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>

<body>

<header class="topbar">

    <div class="brand">
        Attendance System
    </div>

    <button id="menuBtn">☰</button>

</header>

<div class="overlay-menu" id="overlay"></div>

<nav class="side-menu" id="sideMenu">
    <div class="menu-header">
    <img src="assets/logo.png" class="menu-logo">
    <h3>ISKOLAR</h3>
</div>

    <a href="dashboard.php">Dashboard</a>
    <a href="activity   .php">Activities</a>
    <a href="#">Attendance</a>
    <a href="#">Reports</a>
    <a href="logout.php" class="logout-link">
    Logout
</a>

</nav>

<div class="dashboard">

    <div class="stats">

        <div class="stat-card">
            <h3><?= count($activities) ?></h3>
            <p>Activities</p>
        </div>

        <div class="stat-card">
            <h3>0</h3>
            <p>Attendance Today</p>
        </div>

        <div class="stat-card">
            <h3>0</h3>
            <p>Reports</p>
        </div>

    </div>

    <section class="dashboard-card">

        <h1>Activities & Announcements</h1>

        <?php if(count($activities) > 0): ?>

            <?php foreach($activities as $activity): ?>

                <div class="activity-row">

                    <div>

                        <span class="badge">
                            ACTIVITY
                        </span>

                        <h3>
                            <?= htmlspecialchars($activity['name']) ?>
                        </h3>

                    </div>

                    <a
                        href="activity.php?id=<?= $activity['id'] ?>"
                        class="view-btn"
                    >
                        OPEN
                    </a>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p>No activities available.</p>

        <?php endif; ?>

    </section>

    <section class="dashboard-card">

        <h2>Recent Attendance</h2>

        <div class="attendance-row">
            <strong>20240001</strong>
            <span>Present</span>
        </div>

        <div class="attendance-row">
            <strong>20240002</strong>
            <span>Present</span>
        </div>

    </section>

</div>

<script>

const menuBtn = document.getElementById("menuBtn");
const sideMenu = document.getElementById("sideMenu");
const overlay = document.getElementById("overlay");

menuBtn.addEventListener("click", () => {
    sideMenu.classList.toggle("show");
    overlay.classList.toggle("show");
});

overlay.addEventListener("click", () => {
    sideMenu.classList.remove("show");
    overlay.classList.remove("show");
});

</script>

</body>
</html>