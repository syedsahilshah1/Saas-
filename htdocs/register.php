<?php
require_once 'core/functions.php';
$error = ''; $success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password']; // Will hash this

    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email already registered!";
        } else {
            // Hash the password and insert
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$name, $email, $hash])) {
                $success = "Registration successful! You can now <a href='login.php'>log in</a>.";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - RoadMap SaaS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow-sm border-0">
                <h3 class="text-center mb-4">Create Account</h3>
                <?php if ($error): ?><div class="alert alert-danger" role="alert"><?= $error ?></div><?php endif; ?>
                <?php if ($success): ?><div class="alert alert-success" role="alert"><?= $success ?></div><?php endif; ?>
                <form method="post" action="register.php">
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
                <div class="text-center mt-3">
                    <a href="login.php" class="text-decoration-none">Already have an account? Log in</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
