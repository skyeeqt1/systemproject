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
        <form method="POST" action="./assets/includes/add-to-cart.php">
            <div class="row">
            <!-- Cart Table -->
            <div class="col-lg-8">
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                <h5>Shopping Cart</h5>
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
                                <img src="/path/to/image.jpg" class="rounded" width="50" height="50">
                                <span><?= htmlspecialchars($item['ProductName']) ?></span>
                            </td>
                            <td>$<?= number_format($item['price_at_time'], 2) ?></td>
                            <td>
                                <input type="number" class="form-control" name="quantities[<?= $item['product_id'] ?>]" value="<?= $item['quantity'] ?>" min="1" style="width: 70px;">
                            </td>
                            <td class="text-primary fw-semibold">$<?= number_format($item['price_at_time'] * $item['quantity'], 2) ?></td>
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

            <!-- Cart Totals -->
            <div class="col-lg-4">
                <div class="bg-white p-4 rounded shadow-sm">
                <h3 class="text-black font-weight-bold">Cart Totals</h5>
                <ul class="list-unstyled mb-3">
                    <span class="text-black">Total:</span>
                    <span class="text-black">₱<?= $total ?></span>
                    </li>
                </ul>
                <button type="submit" formaction="./checkout.php" formmethod="POST" name="checkout" class="btn btn-primary w-100">Proceed To Checkout</button>
                </div>
            </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php
        include_once 'footer.php';
    ?>


</body>