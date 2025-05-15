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
            <div class="card-picture" style="height: 200px; background-size: cover; background-position: center center; background-repeat: no-repat; background-image: url('<?= $product['ImageURL'] ? htmlspecialchars('.' . $product['ImageURL']) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' ?>');">
            </div>
            <?php /*<img src="<?= $product['ImageURL'] ? htmlspecialchars('.' . $product['ImageURL']) : 'https://thumb.ac-illust.com/b1/b170870007dfa419295d949814474ab2_t.jpeg' ?>" class="card-img-top" alt="<?= htmlspecialchars($product['ProductName']) ?>">*/ ?>
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($product['ProductName']) ?></h5>
                <p class="card-text">Price: ₱<?= htmlspecialchars($product['Price']) ?></p>
                <p class="card-text">Brand: <?= htmlspecialchars($product['BrandName']) ?></p>
                <p class="card-text">Type: <?= htmlspecialchars($product['ProductTypeName']) ?></p>
                
                <div class="add-to-cart-btn">
                    <form action="<?= "http://" . $_SERVER['SERVER_NAME'] ?>/project/systemproject/assets/includes/add-to-cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['productID'] ?>">
                        <input type="hidden" name="price" value="<?= $product['Price'] ?>">
                        <button class="btn btn-secondary" type="submit"  name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
            </div>
           
        </div>
    </div>
<?php
    endforeach;
else:
?>
    <p>No products match the selected filters.</p>
<?php endif; ?>