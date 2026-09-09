<?php
// Database configuration
$host = "localhost";
$dbname = "mris";
$username = "root";   // or your MySQL user
$password = "";       // empty if using sudo mysql

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // If connection fails, stop execution and show error
    die("Database connection failed: " . $e->getMessage());
}
?>