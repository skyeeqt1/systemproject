<?php

// include_once './assets/includes/dbh.inc.php';
require_once 'functions.inc.php'; // Include necessary functions

session_start();

// Check if the session contains a valid user ID
if (!isset($_SESSION['userID'])) {
    header("location: ../../login.php");
    // echo "Please log in to view your cart.";
    exit;
}

$userId = $_SESSION['userID']; // Get the user ID from session

var_dump($_POST);

// Connect to the database
$conn = connectDatabase();
// echo 'test<br>';
// Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    echo "Add to cart request received.<br>";
    // Validate and sanitize input data
    $productId = $_POST['product_id'];
    $price = $_POST['price'];
    echo "Product ID: $productId, Price: $price<br>";
    // Add product to the cart
    addToCart($userId, $productId, $price);

    // Redirect to the cart page after adding the item
    header('Location: ../../cart.php');
    exit;
}

// Handle Remove Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $productId = $_POST['remove_product_id'];
    $cartId = getCartId($userId);

    // Remove product from cart
    removeFromCart($conn, $cartId, $productId);

    // Redirect to the cart page after removal
    header('Location: ../../cart.php');
    exit;
}

// Handle Update Quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $cartId = getCartId($userId);

    // Update quantities for all products in cart
    if (isset($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $productId => $quantity) {
            updateCartQuantity($conn, $cartId, $productId, (int)$quantity);
        }
    }

    // Redirect to the cart page after updating quantities
    header('Location: ../../cart.php');
    exit;
}

?>
