<?php
session_start();
// if (isset($_SESSION['userID'])) {
//     session_start();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/home.css">      
</head>
<body>
    <?php
        include_once 'header.php';
    ?>
    <div class="container pt-5 mt-5">
        <h2>Experience a whole new way of building your dream PC with a fresh perspective and endless possibilities</h2>
        <p>Building your own PC is a satisfying experience. With our fresh approach, we’ll guide you in ensuring that your selected parts are fully compatible</p>

        <div class="pt-4 text-center">
            <a href="custom-build.php"><button class="btn btn-primary">Create Now</button></a>
            <a href="prebuilt.php"><button class="btn btn-secondary">Buy Pre-built PC</button></a>
        </div>
    </div>
    <?php
        include_once 'footer.php';
    ?>


</body>
</html>