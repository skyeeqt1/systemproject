<?php
session_start();
if (!isset($_SESSION['userID'])) {
    echo "Please log in to proceed with checkout.";
    exit;
}
?>

<h2>Checkout</h2>
<form method="POST" action="assets/includes/order.php">
    <label>First Name: <input type="text" name="first_name" required></label><br>
    <label>Last Name: <input type="text" name="last_name" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Phone: <input type="text" name="phone" required></label><br>
    <label>Street Address: <input type="text" name="street_address" required></label><br>
    <label>City: <input type="text" name="city" required></label><br>
    <label>Province: <input type="text" name="province" required></label><br>
    <label>Zip Code: <input type="text" name="zip_code" required></label><br><br>
    
    <button type="submit" name="checkout">Place Order</button>
</form>