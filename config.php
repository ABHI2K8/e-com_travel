<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'travel_agency';

// File path configuration
define('BASE_PATH', realpath(dirname(__FILE__)));

// Database connection
$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Always include this at the end of config.php
require_once BASE_PATH . '/header.php';
?>