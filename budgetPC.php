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
            $conn = connectDatabase();

             // Query the database for budget PCs
             $result = $conn->query("SELECT * FROM budgetpc");
         
             // Check if there are results
             if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) :
            ?>
                    <div class="product-card">
                        <img src="budgetPCs/<?php echo htmlspecialchars($row['bpcImage']); ?>" alt="<?php echo htmlspecialchars($row['bpcName']); ?>">
                        <h3>
                            <a href="PCdetails.php?id=<?php echo htmlspecialchars($row['pcID']); ?>">
                                <?php echo htmlspecialchars($row['bpcName']); ?>
                            </a>
                        </h3>
                        <p class="price">₱<?php echo htmlspecialchars($row['bpcPrice']); ?></p>
                        <a href="PCdetails.php?id=<?php echo htmlspecialchars($row['pcID']); ?>" class="buy-btn">View Details</a>
                    </div>
            <?php
                endwhile;
            } else {
                echo "<p>No products found.</p>";
            }

            // Close the database connection
            $conn->close();
        ?>
    </div>
</body>
</html>
