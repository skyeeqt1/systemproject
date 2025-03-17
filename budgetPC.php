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
    <link rel="stylesheet" href="assets/css/budgetPC.css">
</head>

<body>
    <?php
        include_once 'header.php';
    ?>

    <h2>Prebuilt Budget PCs</h2>
    <div class="product-grid">
        <?php
            $conn = new mysqli("localhost", "root", "", "project");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query("SELECT * FROM budgetpc");

            while ($row = $result->fetch_assoc()) {
                echo "<div class='product-card'>";
                echo "<img src='budgetPCs/{$row['bpcImage']}' alt='{$row['bpcName']}'>";
                echo "<h3><a href='PCdetails.php?id={$row['pcID']}'>{$row['bpcName']}</a></h3>"; 
                echo "<p class='price'>₱{$row['bpcPrice']}</p>";
                echo "<a href='PCdetails.php?id={$row['pcID']}' class='buy-btn'>View Details</a>";
                echo "</div>";
            }
            $conn->close();
        ?>
    </div>
</body>
</html>
