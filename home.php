<?php
include_once './assets/includes/dbh.inc.php';
require_once './assets/includes/functions.inc.php'; // Include necessary functions

session_start();

// Check if the user is logged in
// if (!isset($_SESSION['userID'])) {
//     header("location: ./login.php");
//     // echo "Please log in to view your cart.";
//     exit;
// }



if (isset($_SESSION['userID'])) {
    $userId = $_SESSION['userID']; // Get the user ID from the session
    $cartId = getCartId($userId); // Get the cart ID for the user

    // Get cart items from the database
    $cartItems = getCartItems($userId);
    $total = getCartTotal($conn, $cartId); // Get the total price of the cart
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Builder | Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <div id="carouselExampleIndicators" class="carousel slide p-4">
        <div class="carousel-indicators" style="margin-bottom: 2.5rem;">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner" style="border-radius: 30px;">
            <div class="carousel-item active">
            <img src="assets/img/home-banner-1.webp" class="d-block w-100" alt="assets/img/home-banner-1.webp">
            </div>
            <div class="carousel-item">
            <img src="assets/img/home-banner-2.webp" class="d-block w-100" alt="assets/img/home-banner-2.webp">
            </div>
            <div class="carousel-item">
            <img src="assets/img/home-banner-3.webp" class="d-block w-100" alt="assets/img/home-banner-3.webp">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
    <div class="container-fluid" style="background-color: #fafafa;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center mt-5">Welcome to PC Builder</h1>
                    <p class="text-center">Your one-stop shop for custom-built PCs and pre-built systems. Whether you're a gamer, content creator, or just need a reliable computer, we've got you covered.</p>
                </div>
            </div>
            <div class="row pt-5 gap-3">
                <div class="col" style="min-height: 400px; border-radius: 20px; background-image: linear-gradient(rgba(8, 20, 41, 0.7), rgba(8, 20, 41, 0.6)), url('assets/img/custom-built.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    <div class="row" style="height: 100%;" class="align-items-end">
                        <div class="col-10 align-content-end p-5">
                            <h2 class="text-white">Custom Build Your PC</h2>
                            <p class="text-white">Design your own PC with our easy-to-use system builder. Choose from a wide range of components to create the perfect machine for your needs.</p>
                            <a href="custom-build.php"><button class="btn btn-primary">Customize Now</button></a>
                        </div>
                    </div>
                </div>
                <div class="col" style="min-height: 400px; border-radius: 20px; background-image: linear-gradient(rgba(8, 20, 41, 0.7), rgba(8, 20, 41, 0.6)), url('assets/img/prebuilt.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                    <div class="row" style="height: 100%;" class="align-items-end">
                        <div class="col-10 align-content-end p-5">
                            <h2 class="text-white">Pre-built PC</h2>
                            <p class="text-white">Don't want to build it yourself? Check out our selection of pre-built PCs, ready to go right out of the box.</p>
                            <a href="prebuilt.php"><button class="btn btn-secondary">Buy Pre-built PC</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

        
    <?php
        include_once 'footer.php';
    ?>


</body>


</html>