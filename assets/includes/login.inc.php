<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $pwd = $_POST["pwd"];

    // Initialize database connection
    $conn = connectDatabase();

    // Check for empty input
    if (emptyInputLogin($username, $pwd)) {
        header("location: ../../login.php?error=emptyinput");
        exit();
    }

    // Attempt login
    if (loginUser($conn, $username, $pwd)) {
        // Login successful, redirect to home
        header("location: ../../home.php");
        exit();
    } else {
        // Login failed, redirect to login with error
        header("location: ../../login.php?error=wronglogin");
        exit();
    }
} else {
    // Redirect if accessed without submitting the form
    header("location: ../../login.php");
    exit();
}

?>
