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
        <!-- LEFT -->
        <div class="left">
            <img src="assets/logo.png" alt="logo" class="logo">

            <div class="forgot-box"><img src="assets/peek-water.png" class="peek-water" alt="water mascot"></div>

            <form action="login.php" method="POST">

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit" class="create-btn">
                    Sign In
                </button>

            </form>
        </div>

        <!-- RIGHT -->
        <div class="right">
            <div class="overlay">
                <img src="assets/logo.png" alt="logo" class="logo">
            </div>
        </div>
    </div> 


</body>
</html>