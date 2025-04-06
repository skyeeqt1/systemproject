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


var_dump($cartItems);
?>

<h2>Your Cart</h2>

<?php if (count($cartItems) > 0): ?>
    <form method="POST" action="<?= "http://" . $_SERVER['SERVER_NAME'] ?>/skyee-project/systemproject/assets/includes/add-to-cart.php">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['ProductName']); ?></td>
                        <td>₱<?php echo number_format($item['price_at_time'], 2); ?></td>
                        <td>
                            <input type="number" name="quantities[<?php echo $item['product_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
                        </td>
                        <td>₱<?php echo number_format($item['price_at_time'] * $item['quantity'], 2); ?></td>
                        <td>
                            <!-- Remove Product Button -->
                            <button type="submit" name="remove_product_id" value="<?php echo $item['product_id']; ?>">Remove</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Update Quantities Button -->
        <button type="submit" name="update_quantity">Update Quantities</button>
    </form>

    <h3>Total: ₱<?php echo number_format($total, 2); ?></h3>

<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>
