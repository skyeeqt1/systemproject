<?php

// if (session_status() !== PHP_SESSION_NONE) {
//     // header("location: ../../logout.php");
//     session_unset();
//     session_destroy();
// }

if (session_status() === PHP_SESSION_NONE) {
    header("location: home.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/login.css">      
</head>
<body>
    <?php
        include_once 'header.php';
    ?>
    <div class="container">
        <div class="login-box">
            <img src="assets/img/logo.png" alt="Logo" class="logo-img">
            <h2>Login to Your Account</h2>
            <form action="assets/includes/login.inc.php" method="post">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <button type="submit" name="submit">Login</button>
            </form>
            <div class="links">
                <a href="signup.php">Create an Account</a>
                <a href="#">Forgot Password?</a>
            </div>
        </div>
    </div>
    <?php
        include_once 'footer.php';
    ?>

</body>
</html>
