<?php
include_once './assets/includes/dbh.inc.php';
require_once './assets/includes/functions.inc.php'; // Include necessary functions

session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    echo "Please log in to view your cart.";
    exit;
}

$userId = $_SESSION['userID']; // Get the user ID from the session
$cartId = getCartId($userId); // Get the cart ID for the user

// Get cart items from the database
$cartItems = getCartItems($userId);
$total = getCartTotal($conn, $cartId); // Get the total price of the cart

// var_dump($cartItems);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builder</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/home.css">    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">  
       
</head>
<body>
    <?php
        include_once 'header.php';
    ?>


    <div class="container pt-5 mt-5">
        <div class="row">
        <!-- Cart Table -->
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h2>Checkout</h2>
                    
                    <form method="POST" action="assets/includes/order.php">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label for="street_address" class="form-label">Street Address</label>
                                <input type="text" id="street_address" name="street_address" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>
                                <input type="text" id="city" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label for="province" class="form-label">Province</label>
                                <input type="text" id="province" name="province" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="zip_code" class="form-label">Zip Code</label>
                                <input type="text" id="zip_code" name="zip_code" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" name="checkout" class="btn btn-primary w-100">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Cart Totals -->
            <div class="col-lg-6">
                <div class="bg-white p-4 rounded shadow-sm">
                    <div class="table-responsive">
                        <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($cartItems)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Your cart is empty.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                <td class="d-flex align-items-center gap-3">
                                    <img src="./<?= $item['ImageURL']; ?>" class="rounded" width="50" height="50">
                                    <span><?= htmlspecialchars($item['ProductName']) ?></span>
                                </td>
                                <td>$<?= number_format($item['price_at_time'], 2) ?></td>
                                <td>
                                    <input type="number" class="form-control" name="quantities[<?= $item['product_id'] ?>]" value="<?= $item['quantity'] ?>" min="1" style="width: 70px;">
                                </td>
                                <td class="text-primary fw-semibold">₱<?= number_format($item['price_at_time'] * $item['quantity'], 2) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-danger" type="submit" name="remove_product_id" value="<?= $item['product_id'] ?>">×</button>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php
        include_once 'footer.php';
    ?>


</body>