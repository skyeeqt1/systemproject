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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/prebuilt.css">      
</head>
<body>
    <?php
        include_once 'header.php';
    ?>
    <header>
        <h1>Choose Your Preference</h1>
    </header>
    <div class="pc-options">
        <a href="budgetPC.php"><button>Budget PC</button></a>
        <a href="#"><button>Gaming PC</button></a>
        <a href="#"><button>Workstation PC</button></a>
    </div>
    <?php
        include_once 'footer.php';
    ?>
</body>
</html>
