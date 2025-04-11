<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'travelgo';

// File path configuration
define('BASE_PATH', realpath(dirname(__FILE__)));

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to check if the user is logged in
function checkAuthentication() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Database connection
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Check for connection errors
}

// Debugging: Uncomment the line below to confirm the connection
// echo "Database connected successfully!";

?>