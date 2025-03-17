<?php
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<nav>
    <div class="logo"><img src="assets/img/logo.png" alt="logo"><a href="home.php">PC <span>Builder</span></a></div>
    <ul>
        <li><a href="#" class="<?php echo ($current_page == '') ? 'active' : ''; ?>">System Builder</a></li>
        <li><a href="prebuilt.php" class="<?php echo ($current_page == 'prebuilt.php' || $current_page  == 'budgetPC.php' || $current_page == 'PCdetails.php') ? 'active' : ''; ?>">Pre-Build PC</a></li>
        <li><a href="#" class="<?php echo ($current_page == '') ? 'active' : ''; ?>">Laptops</a></li>
        
    </ul>

    <div class="auth-links">
        <?php
        if (isset($_SESSION["username"])) {
            echo '<a href="#" class="' . (($current_page == 'cart.php') ? 'active' : '') . '">
            <i class="bi bi-cart"></i>Cart</a>';

            echo '<a href="assets/includes/logout.php" class="' . (($current_page == 'logout.php') ? 'active' : '') . '">
            <i class="bi bi-person-circle"></i>Logout</a>';
        }
        else {
            echo '<a href="login.php" class="' . (($current_page == 'login.php' || $current_page == 'signup.php') ? 'active' : '') . '">
            <i class="bi bi-person-circle"></i>Log In / Register</a>';
        }
        ?>
    </div>
</nav>

