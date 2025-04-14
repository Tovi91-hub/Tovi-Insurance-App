<?php
$host = 'localhost';
$dbname = 'ToviLife';
$username = 'app_user'; // replace with your actual MySQL app-level username
$password = 'securePassword123'; // replace with your actual MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("A database connection error occurred. Please contact support.");
}
?>