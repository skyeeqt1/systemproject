<?php
// Database connection function
function connectDatabase($serverName = "localhost", $serverUsername = "root", $dbPassword = "", $dbName = "project") {
    // Enable error reporting during development (disable in production)
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Attempt to establish a database connection
    $conn = mysqli_connect($serverName, $serverUsername, $dbPassword, $dbName);

    if (!$conn) {
        // Log connection errors instead of exposing them to the user
        error_log("Database Connection Failed: " . mysqli_connect_error());
        die("Database connection failed. Please try again later.");
    }

    return $conn;
}

$conn = connectDatabase();
?>