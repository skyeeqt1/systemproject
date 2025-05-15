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
    $query = "SELECT DISTINCT p.productID, p.ProductName, p.Price, p.ImageURL, b.BrandName, pt.ProductTypeName
              FROM products p
              INNER JOIN brands b ON p.BrandID = b.BrandID
              INNER JOIN producttypes pt ON p.ProductTypeID = pt.ProductTypeID
              LEFT JOIN producttags ptg ON p.ProductID = ptg.ProductID
              WHERE 1=1
              AND p.ProductTypeID NOT IN (11, 12)";

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

function getPrebuilt($conn, $priceSQL, $brandIDs, $productTypeIDs, $tagIDs) {
    $query = "SELECT DISTINCT p.productID, p.ProductName, p.Price, p.ImageURL, b.BrandName, pt.ProductTypeName
    FROM products p
    INNER JOIN brands b ON p.BrandID = b.BrandID
    INNER JOIN producttypes pt ON p.ProductTypeID = pt.ProductTypeID
    LEFT JOIN producttags ptg ON p.ProductID = ptg.ProductID
    WHERE 1=1
    AND p.ProductTypeID IN (11, 12)";

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



function getCartId($userId) {
    $conn = connectDatabase();

    // Check if the user already has a cart
    $stmt = mysqli_prepare($conn, "SELECT cart_id FROM Carts WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cart = mysqli_fetch_assoc($result);

    // If no cart, create one
    if (!$cart) {
        $stmt = mysqli_prepare($conn, "INSERT INTO Carts (user_id) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        return mysqli_insert_id($conn);
    }

    return $cart['cart_id'];
}

// function getCartId($userId) {
//     $conn = connectDatabase();

//     // Check if the user already has a cart
//     $stmt = mysqli_prepare($conn, "SELECT cart_id FROM Carts WHERE user_id = ?");
//     mysqli_stmt_bind_param($stmt, "i", $userId);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);
//     $cart = mysqli_fetch_assoc($result);

//     // If no cart, create one
//     if (!$cart) {
//         $stmt = mysqli_prepare($conn, "INSERT INTO Carts (user_id) VALUES (?)");
//         mysqli_stmt_bind_param($stmt, "i", $userId);
//         mysqli_stmt_execute($stmt);
//         $cartId = mysqli_insert_id($conn); // Get the newly created cart ID
//         // echo "New cart created with ID: " . $cartId; // Debugging line
//         return $cartId;
//     }

//     return $cart['cart_id'];
// }

function addToCart($userId, $productId, $price) {
    $conn = connectDatabase();
    $cartId = getCartId($userId);

    // Check if item already in cart
    $checkStmt = mysqli_prepare($conn, "SELECT cart_detail_id, quantity FROM Cart_Details WHERE cart_id = ? AND product_id = ?");
    mysqli_stmt_bind_param($checkStmt, "ii", $cartId, $productId);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);
    $item = mysqli_fetch_assoc($result);
    mysqli_stmt_close($checkStmt); // ✅ Close after use

    if ($item) {
        // Update quantity
        $newQty = $item['quantity'] + 1;
        $updateStmt = mysqli_prepare($conn, "UPDATE Cart_Details SET quantity = ? WHERE cart_detail_id = ?");
        mysqli_stmt_bind_param($updateStmt, "ii", $newQty, $item['cart_detail_id']);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt); // ✅ Close after use
    } else {
        // Insert new item
        $insertStmt = mysqli_prepare($conn, "INSERT INTO Cart_Details (cart_id, product_id, quantity, price_at_time) VALUES (?, ?, 1, ?)");
        mysqli_stmt_bind_param($insertStmt, "iid", $cartId, $productId, $price);
        mysqli_stmt_execute($insertStmt);
        mysqli_stmt_close($insertStmt); // ✅ Close after use
    }
}


function getCartItems($userId) {
    $conn = connectDatabase();
    $cartId = getCartId($userId);

    $stmt = mysqli_prepare($conn, "
        SELECT cd.product_id, p.ProductName, p.ImageURL, cd.quantity, cd.price_at_time 
        FROM Cart_Details cd
        JOIN Products p ON cd.product_id = p.ProductID
        WHERE cd.cart_id = ?
    ");
    mysqli_stmt_bind_param($stmt, "i", $cartId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }

    return $items;
}


function removeFromCart($conn, $cartId, $productId) {
    $sql = "DELETE FROM Cart_Details WHERE cart_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $cartId, $productId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Update product quantity in the cart
function updateCartQuantity($conn, $cartId, $productId, $quantity) {
    $conn = connectDatabase();
    if ($quantity <= 0) {
        removeFromCart($conn, $cartId, $productId); // If quantity is zero or less, remove it
        return;
    }

    $sql = "UPDATE Cart_Details SET quantity = ? WHERE cart_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $quantity, $cartId, $productId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Calculate total cart price
function getCartTotal($conn, $cartId) {
    $sql = "SELECT SUM(quantity * price_at_time) AS total FROM Cart_Details WHERE cart_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cartId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row['total'] ?? 0;
}

function handleCheckout($userId, $checkoutData) {
    $conn = connectDatabase();
    $cartId = getCartId($userId);
    $cartItems = getCartItems($userId);

    if (empty($cartItems)) {
        return false;
    }

    $total = getCartTotal($conn, $cartId);

    // 1. Insert into Addresses
    $addressId = insertAddress($conn, $checkoutData);

    // 2. Insert into Orders
    $orderId = insertOrder($conn, $userId, $total);

    // 3. Link Order to Address
    linkOrderToAddress($conn, $orderId, $addressId);

    // 4. Insert Order Items
    insertOrderItems($conn, $orderId, $cartItems);

    // 5. Clear the Cart
    clearCart($conn, $cartId);

    return $orderId;
}

function insertAddress($conn, $data) {
    $stmt = $conn->prepare("INSERT INTO Addresses (first_name, last_name, email, phone, street_address, city, province, zip_code)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss",
        $data['first_name'], $data['last_name'], $data['email'], $data['phone'],
        $data['street_address'], $data['city'], $data['province'], $data['zip_code']
    );
    $stmt->execute();
    $addressId = $stmt->insert_id;
    $stmt->close();
    return $addressId;
}

function insertOrder($conn, $userId, $total) {
    $stmt = $conn->prepare("INSERT INTO Orders (user_id, total_amount) VALUES (?, ?)");
    $stmt->bind_param("id", $userId, $total);
    $stmt->execute();
    $orderId = $stmt->insert_id;
    $stmt->close();
    return $orderId;
}

function linkOrderToAddress($conn, $orderId, $addressId) {
    $stmt = $conn->prepare("INSERT INTO Order_Addresses (order_id, address_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $orderId, $addressId);
    $stmt->execute();
    $stmt->close();
}

function insertOrderItems($conn, $orderId, $cartItems) {
    foreach ($cartItems as $item) {
        $stmt = $conn->prepare("INSERT INTO Order_Items (order_id, product_id, quantity, price_at_time)
                                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $orderId, $item['product_id'], $item['quantity'], $item['price_at_time']);
        $stmt->execute();
        $stmt->close();
    }
}

function clearCart($conn, $cartId) {
    $stmt = $conn->prepare("DELETE FROM Cart_Details WHERE cart_id = ?");
    $stmt->bind_param("i", $cartId);
    $stmt->execute();
    $stmt->close();
}
?>


