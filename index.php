<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>

<div class="container">

    <div class="left">

        <img src="assets/logo.png" class="logo">

        <h1 class="title">
            Attendance System
        </h1>

        <form action="login.php" method="POST">

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Enter email"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter password"
                required
            >

            <button type="submit" class="create-btn">
                Sign In
            </button>

        </form>

    </div>

    <div class="right">

        <div class="overlay">

            <img
                src="assets/logo.png"
                class="big-logo"
            >

        </div>

    </div>

</div>

</body>
</html>