<?php
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $confirmpwd = $_POST["confirmpwd"];

    require_once 'dbh.inc.php'; // Database connection
    require_once 'functions.inc.php'; // Functions file

    // Use the new signupUser function to handle all validation and creation
    signupUser($username, $email, $pwd, $confirmpwd);
} else {
    header("location: ../../signup.php");
    exit();
}