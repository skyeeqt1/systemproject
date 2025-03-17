<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/signup.css">
    
      
</head>
<body>
    <?php
        include_once 'header.php';
    ?>
    <div class="container">
        <div class="signup-box">
            <img src="assets/img/logo.png" alt="Logo" class="logo-img">
            <h2>Create Your Account</h2>

            <form action="assets/includes/signup.inc.php" method="POST">
                <input type="text" name="username" placeholder="Username" required autocomplete="off" class="full">
                <input type="email" name="email" placeholder="Email" required autocomplete="off" class="full">
                <input type="password" name="pwd" placeholder="Password" required class="full">
                <input type="password" name="confirmpwd" placeholder="Confirm Password" required class="full">
                <button type="submit" name="submit">Register</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="login.php">Sign In</a>
            </div>
        </div>
    </div>
    
    <?php
        include_once 'footer.php';
    ?>

</body>
</html>
