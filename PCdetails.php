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
    <link rel="stylesheet" href="assets/css/PCdetails.css">
</head>

<body>
    <?php
        include_once 'header.php';
    ?>

    <div class="container">
        <?php
        $conn = new mysqli("localhost", "root", "", "project");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['id'])) {
            $id = intval($_GET['id']); 

            $result = $conn->query("SELECT * FROM budgetpc WHERE pcID = $id");

            if ($row = $result->fetch_assoc()) {
                echo "<div class='product-container'>";
                
                
                echo "<div class='product-image'>";
                echo "<img src='budgetPCs/{$row['bpcImage']}' alt='{$row['bpcName']}'>";
                echo "</div>";

                
                echo "<div class='product-details'>";
                echo "<h2>{$row['bpcName']}</h2>";
                echo "<p class='price'>₱{$row['bpcPrice']}</p>";
                
                echo "<div class='button-container'>";
                echo "<a href='checkout.php?id={$row['pcID']}' class='buy-btn'>Buy Now</a>";
                echo "<a href='#' class='add-cart-btn'>Add to Cart</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "<p class='desc'>Description: <br><br>{$row['bpcDescription']}</p>";
            } else {
                echo "PC not found.";
            }
        } else {
            echo "No PC selected.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
