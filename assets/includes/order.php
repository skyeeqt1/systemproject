<?php
require_once 'functions.inc.php';
session_start();

if (!isset($_SESSION['userID'])) {
    echo "Unauthorized.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $userId = $_SESSION['userID'];
    $checkoutData = $_POST;

    $success = handleCheckout($userId, $checkoutData);

    if ($success) {
        header("Location: ../../thank-you.php");
        exit;
    } else {
        echo "Something went wrong. Please try again.";
    }
}