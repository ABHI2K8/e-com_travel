<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ecomtravel_db';

// File path configuration
define('BASE_PATH', realpath(dirname(__FILE__)));

// Database connection
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



?>