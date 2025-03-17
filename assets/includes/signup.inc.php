<?php

if (isset($_POST["submit"])) {
    
    $username = $_POST["username"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $confirmpwd = $_POST["confirmpwd"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($username, $email, $pwd, $confirmpwd) !== false) {
        header("location: ../../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUsername($username) !== false) {
        header("location: ../../signup.php?error=invaliduid");
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: ../../signup.php?error=invalidEmail");
        exit();
    }
    if (pwdMatch($pwd, $confirmpwd) !== false) {
        header("location: ../../signup.php?error=passwordsdontmatch");
        exit();
    }
    if (usernameExists($conn, $username, $email) !== false) {
        header("location: ../../signup.php?error=usernametaken");
    }

    createUser($conn, $username, $email, $pwd);

}
else {
    header("location: ../../signup.php");
    exit();
}
