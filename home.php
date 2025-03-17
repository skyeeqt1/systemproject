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
    <link rel="stylesheet" href="assets/css/home.css">      
</head>
<body>
    <?php
        include_once 'header.php';
    ?>
    <section>
        <div class ="left-section">
            <h1>Experience a whole new way of building your dream PC with a fresh perspective and endless possibilities</h1>
            <p>Building your own PC is a satisfying experience. With our fresh approach, we’ll guide you in ensuring that your selected parts are fully compatible</p>
        </div>
    </section>
        <div class="button-container">
        <button class="btn btn-primary">Create Now</button>
        <a href="prebuilt.php"><button class="btn btn-secondary">Buy Pre-built PC</button></a>
    </div>
    <?php
        include_once 'footer.php';
    ?>
    
</body>
</html>