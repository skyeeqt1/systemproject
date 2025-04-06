<?php

include_once './assets/includes/dbh.inc.php';
require_once './assets/includes/functions.inc.php'; // Include necessary functions

$priceRanges = isset($_GET['priceRange']) ? $_GET['priceRange'] : [];
$brandIDs = isset($_GET['brand']) ? array_map('intval', $_GET['brand']) : [];
$productTypeIDs = isset($_GET['productType']) ? array_map('intval', $_GET['productType']) : [];
$tagIDs = isset($_GET['tag']) ? array_map('intval', $_GET['tag']) : [];

// Parse the price ranges into SQL conditions
$priceConditions = [];
foreach ($priceRanges as $range) {
    if ($range === "400+") {
        $priceConditions[] = "price >= 400"; // Price above $400
    } elseif (preg_match('/(\d+)-(\d+)/', $range, $matches)) {
        $min = intval($matches[1]);
        $max = intval($matches[2]);
        $priceConditions[] = "price BETWEEN $min AND $max"; // Specific range
    }
}

// Combine all price conditions into a single SQL OR clause
$priceSQL = !empty($priceConditions) ? "(" . implode(" OR ", $priceConditions) . ")" : null;

// Fetch filtered products
$filteredProducts = getFilteredProducts($conn, $priceSQL, $brandIDs, $productTypeIDs, $tagIDs);

// Output filtered products as HTML
if (!empty($filteredProducts)):
    foreach ($filteredProducts as $product):
?>
    <div class="col-md-4 mt-4">
        <div class="card">
            <img src="<?= htmlspecialchars($product['ImageURL'] ? './product_img/'.$product['ProductName']  : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg') ?>" class="card-img-top" alt="<?= htmlspecialchars($product['ProductName']) ?>">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product['ProductName']) ?></h5>
                <p class="card-text">Price: ₱<?= htmlspecialchars($product['Price']) ?></p>
                <p class="card-text">Brand: <?= htmlspecialchars($product['BrandName']) ?></p>
                <p class="card-text">Type: <?= htmlspecialchars($product['ProductTypeName']) ?></p>
            </div>
        </div>
    </div>
<?php
    endforeach;
else:
?>
    <p>No products match the selected filters.</p>
<?php endif; ?>