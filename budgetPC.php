<?php
    session_start();
    include_once './assets/includes/dbh.inc.php';
    require_once './assets/includes/functions.inc.php'; // Include necessary functions
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
            $budgetPCs = getBudgetPCs($conn);
            if (!empty($budgetPCs)) : ?>
            <?php foreach ($budgetPCs as $pc) : ?>
                <div class="product-card">
                    <img src="budgetPCs/<?php echo htmlspecialchars($pc['bpcImage']); ?>" alt="<?php echo htmlspecialchars($pc['bpcName']); ?>">
                    <h3>
                        <a href="PCdetails.php?id=<?php echo htmlspecialchars($pc['pcID']); ?>">
                            <?php echo htmlspecialchars($pc['bpcName']); ?>
                        </a>
                    </h3>
                    <p class="price">₱<?php echo htmlspecialchars($pc['bpcPrice']); ?></p>
                    <a href="PCdetails.php?id=<?php echo htmlspecialchars($pc['pcID']); ?>" class="buy-btn">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
