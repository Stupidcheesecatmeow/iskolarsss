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

<title>Activities</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

<link rel="stylesheet" href="styles/dashboard.css">
<link rel="stylesheet" href="styles/activity.css">

</head>

<body>

<header class="topbar">

```
<div class="brand">
    Attendance System
</div>

<button id="menuBtn">☰</button>
```

</header>

<div class="overlay-menu" id="overlay"></div>

<nav class="side-menu" id="sideMenu">

```
<div class="menu-header">

    <img src="assets/logo.png" class="menu-logo">

    <h3>ISKOLAR</h3>

</div>

<a href="dashboard.php">Dashboard</a>
<a href="activity.php">Activity</a>
<a href="attendance.php">Attendance</a>
<a href="reports.php">Reports</a>

<a href="logout.php" class="logout-link">
    Logout
</a>
```

</nav>

<div class="dashboard">

```
<section class="dashboard-card">

    <h1>Activity Management</h1>

    <form
        action="create_activity.php"
        method="POST"
        class="create-form"
    >

        <input
            type="text"
            name="activity_name"
            placeholder="Enter Activity Name"
            required
        >

        <button type="submit">
            Create Activity
        </button>

    </form>

</section>

<section class="dashboard-card">

    <h2>Activities</h2>

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

                    <small>
                        <?= $activity['created_at'] ?>
                    </small>

                </div>

                <div class="activity-actions">

                    <a
                        href="attendance.php?id=<?= $activity['id'] ?>"
                        class="view-btn"
                    >
                        OPEN
                    </a>

                    <a
                        href="delete_activity.php?id=<?= $activity['id'] ?>"
                        class="delete-btn"
                        onclick="return confirm('Delete Activity?')"
                    >
                        DELETE
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p>No activities available.</p>

    <?php endif; ?>

</section>
```

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

