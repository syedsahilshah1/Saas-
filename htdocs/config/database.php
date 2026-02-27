<?php
// InfinityFree Connection Credentials
// Replace these with the details from your InfinityFree dashboard

$host = 'localhost';        // InfinityFree DB Host
$dbname = 'roadmap_saas';   // InfinityFree DB Name
$user = 'root';             // InfinityFree DB User
$pass = '';                 // InfinityFree DB Password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    // Setting Exception Mode for error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Setting default fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
