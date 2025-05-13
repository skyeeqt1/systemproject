<?php

// if (session_status() !== PHP_SESSION_NONE) {
//     // header("location: ../../logout.php");
//     session_unset();
//     session_destroy();
// }
session_start();
session_regenerate_id(true); // Refresh the session ID


if ( !empty($_SESSION) ) {
    header("location: home.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builder | Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/login.css">    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <?php
        include_once 'header.php';
    ?>
    <div class="login-container">
        <div class="login-box">
            <img src="assets/img/logo.png" alt="Logo" class="logo-img">
            <h2>Login to Your Account</h2>
            <form action="assets/includes/login.inc.php" method="post">
                <input class="input-type" type="text" name="username" placeholder="Username">
                <input class="input-type" type="password" name="pwd" placeholder="Password">
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
