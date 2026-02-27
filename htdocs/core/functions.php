<?php
session_start();

// Include database config
require_once __DIR__ . '/../config/database.php';

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to redirect unauthenticated users
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

// Function to sanitize user input to prevent XSS
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>
