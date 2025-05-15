<?php
    $current_page = basename($_SERVER['PHP_SELF']);
?>

<nav>
    
    <div class="container-fluid bg-light-blue py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-2 logo text-left">
                    <a href="./home.php"><img src="assets/img/logo.png" alt="logo" width=200></a>
                </div>
                <div class="col-md-7 justify-content-center d-flex gap-3">
                    <a class="nav-link text-dark fw-medium" href="./custom-build.php">System Builder</a>
                    <a class="nav-link text-dark fw-medium" href="./prebuilt.php">Pre-built PC</a>
                </div>

                <div class="col-md-3 d-flex gap-3 align-items-center justify-content-end">
                    <?php
                        if (isset($_SESSION["username"])) { ?>
                        <div class="cart-icon" data-bs-toggle="offcanvas" data-bs-target="#cartPanel" aria-controls="cartPanel">
                                <i class="fas fa-shopping-cart fa-1x"></i>
                            </div>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="cartPanel" aria-labelledby="cartPanelLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="cartPanelLabel">Your Cart</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <?php $carttotal = 0; ?>
                                    <?php if (!empty($cartItems)): ?>
                                    <ul class="list-group mb-3">
                                        <?php foreach ($cartItems as $item): 
                                        
                                        $subtotal = $item['price_at_time'] * $item['quantity'];
                                        $carttotal += $subtotal;
                                        ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-start flex-column">
                                            <div class="d-flex w-100 justify-content-between">
                                            <strong><?= htmlspecialchars($item['ProductName']) ?></strong>
                                            <small class="text-muted">₱<?= number_format($item['price_at_time'], 2) ?></small>
                                            </div>
                                            <div class="d-flex justify-content-between w-100 mt-1">
                                            <small>Qty: <?= $item['quantity'] ?></small>
                                            <small>Subtotal: ₱<?= number_format($subtotal, 2) ?></small>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>

                                    <div class="d-flex justify-content-between fw-bold mb-3">
                                        <span>Total</span>
                                        <span>₱<?= number_format($carttotal, 2) ?></span>
                                    </div>

                                    <a href="./cart.php" class="btn btn-primary w-100">View Full Cart</a>
                                    <a href="./checkout.php" class="btn btn-success w-100 mt-2">Proceed to Checkout</a>

                                    <?php else: ?>
                                    <h3 class="text-center mt-5 text-muted">No items yet on your cart</h3>
                                    <?php endif; ?>
                                    <!-- Bootstrap JS -->
                                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                                </div>
                            </div>
                            
                            <?php
                            echo    '<div class="icon-button">
                                        <a href="assets/includes/logout.php" class="' . (($current_page == 'logout.php') ? 'active' : '') . '">
                                            <i class="fas fa-user fa-1x"></i>Logout
                                        </a>
                                    </div>';
                        }
                        else {
                            echo    '<div class="icon-button">
                                        <a href="login.php" class="' . (($current_page == 'login.php' || $current_page == 'signup.php') ? 'active' : '') . '">
                                            <i class="fas fa-user fa-1x"></i>Login/Sign up
                                        </a>
                                    </div>';
                        }
                    ?>
                </div>
            </div>          
        </div>
    </div>
</nav>

