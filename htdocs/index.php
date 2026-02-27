<?php
require_once 'core/functions.php';

// If logged in, go to dashboard
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Roadmap SaaS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <h1 class="display-4 font-weight-bold text-primary">Your Journey Abroad Starts Here 🚀</h1>
        <p class="lead mt-3 text-secondary">Manage university applications, track documents, and discover scholarships – all in one place.</p>
        <div class="mt-4">
            <a href="login.php" class="btn btn-primary btn-lg px-4 me-2">Log In</a>
            <a href="register.php" class="btn btn-outline-primary btn-lg px-4">Register Now</a>
        </div>
        <div class="mt-5">
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=800" class="img-fluid rounded shadow" alt="Student studying">
        </div>
    </div>
</body>
</html>
