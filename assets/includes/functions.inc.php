<?php
require_once 'dbh.inc.php'; // Include the connection function

function loginUser($conn, $usernameOrEmail, $pwd) {
    // Validate inputs
    if (empty($usernameOrEmail) || empty($pwd)) {
        return false; // Missing inputs
    }

    // Check if the user exists (using username or email)
    $user = usernameExists($conn, $usernameOrEmail, $usernameOrEmail);
    if ($user === false) {
        return false; // User does not exist
    }

    // Get the hashed password from the database
    $pwdHashed = $user["pwd"];

    // Verify the password
    if (!password_verify($pwd, $pwdHashed)) {
        return false; // Password is incorrect
    }

    // Start session securely if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Store user information in session variables
    $_SESSION["userID"] = $user["userID"];
    $_SESSION["username"] = $user["username"];

    // Successful login
    return true;
}

function createUser($conn, $username, $email, $pwd) {
    $sql = "INSERT INTO users (username, email, pwd) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    // Debug: Check if statement preparation fails
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Statement preparation failed: " . mysqli_error($conn));
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);

    // Debug: Check if execution is successful
    if (mysqli_stmt_affected_rows($stmt) <= 0) {
        die("Error inserting user: " . mysqli_error($conn));
    }

    mysqli_stmt_close($stmt);
    header("location: ../../home.php");
    exit();
}

function signupUser($username, $email, $pwd, $confirmpwd) {
    $conn = connectDatabase(); // Establish database connection

    // Validate if any fields are empty
    if (empty($username) || empty($email) || empty($pwd) || empty($confirmpwd)) {
        return false; // Missing inputs
    }

    // Validate username format
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        return false; // Invalid username format
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false; // Invalid email format
    }

    // Check if passwords match
    if ($pwd !== $confirmpwd) {
        return false; // Passwords do not match
    }

    // Check if username or email already exists
    if (usernameExists($conn, $username, $email)) {
        return false; // User already exists
    }

    // Insert user into the database
    $sql = "INSERT INTO users (username, email, pwd) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false; // SQL statement preparation failed
    }

    // Hash the password for security
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    // Bind and execute the SQL statement
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn); // Close the connection

    return true; // Signup successful
}

function emptyInputLogin($username, $pwd) {
    return empty($username) || empty($pwd);
}

// Check if username or email exists in the database
function usernameExists($conn, $username, $email) {
    // Validate inputs
    if (empty($username) && empty($email)) {
        return false; // Prevent unnecessary query execution
    }

    $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);

    // Prepare the statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        error_log("Statement preparation failed: " . mysqli_error($conn)); // Log error for debugging
        return false; // Return false on failure
    }

    // Bind parameters and execute the query
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    // Fetch the user row if it exists
    $row = mysqli_fetch_assoc($resultData);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Return user data if found, or false if not
    return $row ?: false;
}

function getBrands($conn) {
    $sql = "SELECT BrandID, BrandName FROM brands ORDER BY BrandName ASC;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        error_log("Failed to prepare statement in getBrands: " . mysqli_error($conn));
        return [];
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $brands = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $brands[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $brands;
}

function getProductTypes($conn) {
    $sql = "SELECT ProductTypeID, ProductTypeName FROM producttypes ORDER BY ProductTypeName ASC;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        error_log("Failed to prepare statement in getProductTypes: " . mysqli_error($conn));
        return [];
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $productTypes = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $productTypes[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $productTypes;
}

function getTags($conn) {
    // SQL query to select all tags
    $sql = "SELECT * FROM Tags ORDER BY tagName ASC;";
    $stmt = mysqli_stmt_init($conn);

    // Prepare the statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        error_log("SQL Statement Preparation Failed: " . mysqli_error($conn));
        return []; // Return an empty array if the query fails
    }

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $resultData = mysqli_stmt_get_result($stmt);

    // Fetch all tags into an array
    $tags = [];
    while ($row = mysqli_fetch_assoc($resultData)) {
        $tags[] = $row;
    }

    // Close the statement and return tags
    mysqli_stmt_close($stmt);
    return $tags;
}
function getFilteredProducts($conn, $priceSQL, $brandIDs, $productTypeIDs, $tagIDs) {
    $query = "SELECT p.productID, p.ProductName, p.Price, p.ImageURL, b.BrandName, pt.ProductTypeName
              FROM products p
              INNER JOIN brands b ON p.BrandID = b.BrandID
              INNER JOIN producttypes pt ON p.ProductTypeID = pt.ProductTypeID
              LEFT JOIN producttags ptg ON p.ProductID = ptg.ProductID
              WHERE 1=1";

    // Add price conditions
    if ($priceSQL) {
        $query .= " AND $priceSQL";
    }

    // Add brand filters
    if (!empty($brandIDs)) {
        $brandPlaceholders = implode(',', array_fill(0, count($brandIDs), '?'));
        $query .= " AND p.brandID IN ($brandPlaceholders)";
    }

    // Add product type filters
    if (!empty($productTypeIDs)) {
        $typePlaceholders = implode(',', array_fill(0, count($productTypeIDs), '?'));
        $query .= " AND p.productTypeID IN ($typePlaceholders)";
    }

    // Add tag filters
    if (!empty($tagIDs)) {
        $tagPlaceholders = implode(',', array_fill(0, count($tagIDs), '?'));
        $query .= " AND ptg.tagID IN ($tagPlaceholders)";
    }

    // Prepare statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind parameters
    $paramTypes = '';
    $paramValues = [];
    if (!empty($brandIDs)) {
        $paramTypes .= str_repeat('i', count($brandIDs));
        $paramValues = array_merge($paramValues, $brandIDs);
    }
    if (!empty($productTypeIDs)) {
        $paramTypes .= str_repeat('i', count($productTypeIDs));
        $paramValues = array_merge($paramValues, $productTypeIDs);
    }
    if (!empty($tagIDs)) {
        $paramTypes .= str_repeat('i', count($tagIDs));
        $paramValues = array_merge($paramValues, $tagIDs);
    }

    if (!empty($paramTypes)) {
        mysqli_stmt_bind_param($stmt, $paramTypes, ...$paramValues);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch products
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    mysqli_stmt_close($stmt);
    return $products;
}

function getBudgetPCs($conn) {
    // SQL query to select all budget PCs
    $sql = "SELECT * FROM budgetpc ORDER BY bpcName ASC;";
    $stmt = mysqli_stmt_init($conn);

    // Prepare the statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        error_log("SQL Statement Preparation Failed: " . mysqli_error($conn));
        return []; // Return an empty array if the query fails
    }

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $resultData = mysqli_stmt_get_result($stmt);

    // Fetch all budget PCs into an array
    $budgetPCs = [];
    while ($row = mysqli_fetch_assoc($resultData)) {
        $budgetPCs[] = $row;
    }

    // Close the statement and return budget PCs
    mysqli_stmt_close($stmt);
    return $budgetPCs;
}
?>


