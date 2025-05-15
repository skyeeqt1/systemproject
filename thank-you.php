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
    
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
            <div class="alert alert-success" role="alert">
                <h1>Thank you for your order!</h1>
                <p>Your order has been successfully placed. We appreciate your business!</p>
                <a href="./home.php" class="btn btn-primary">Go back to home</a>
                
            </div>
            </div>
        </div>
    </div>
    <?php
        include_once 'footer.php';
    ?>

</body>
</html>
