<?php

function emptyInputSignup($username, $email, $pwd, $confirmpwd) {
    $result = false; 
    if (empty($username) || empty($email) || empty($pwd) || empty($confirmpwd)) {
        $result = true;
    }
    return $result;
}


function invalidUsername($username) {
    $result = false; 
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {   
        $result = true;
    }
    return $result;
}


function invalidEmail($email) {
    $result = false; 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {   
        $result = true;
    }
    return $result;
}


function pwdMatch($pwd, $confirmpwd) {
    $result = false; 
    if ($pwd !== $confirmpwd) {   
        $result = true;
    }
    return $result;
}


function usernameExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss",  $username, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        mysqli_stmt_close($stmt); 
        return $row; 
    } 
    
    mysqli_stmt_close($stmt);
    return false;
}


function createUser($conn, $username, $email, $pwd) {
    if (usernameExists($conn, $username, $email)) {
        header("location: ../../signup.php?error=userexists");
        exit();
    }

    $sql = "INSERT INTO users (username, email, pwd) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss",  $username, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    header("location: ../../signup.php?error=none");
    exit();
}


function emptyInputLogin($username, $pwd) {
    return empty($username) || empty($pwd);
}



function loginUser($conn, $username, $pwd) {
    $usernameExists = usernameExists($conn, $username, $username);

    if ($usernameExists === false) {
        header("location: ../../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $usernameExists["pwd"];
    $checkedpwd = password_verify($pwd, $pwdHashed);

    if ($checkedpwd === false) {
        header("location: ../../login.php?error=wronglogin");
    }
    else if ($checkedpwd === true) {
        session_start();
        $_SESSION["userID"] = $usernameExists["userID"];
        $_SESSION["username"] = $usernameExists["username"];
        header("location: ../../home.php");
        exit(); 
    }
}