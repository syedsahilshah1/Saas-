<?php
require_once 'core/functions.php';
requireLogin();

// Fetch summary data for the dashboard overview
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM applications WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_apps = $stmt->fetch()['total'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Roadmap SaaS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="d-flex h-100">
    <!-- Sidebar -->
    <div class="sidebar p-3 text-white" style="width: 250px;">
        <h4 class="mb-4 d-flex align-items-center"><i class="fa-solid fa-graduation-cap me-2 text-primary"></i> <span class="fs-5 fw-bold">Roadmap Saas</span></h4>
        <hr class="text-secondary">
        <ul class="nav flex-column mb-auto">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link active"><i class="fa-solid fa-house me-2"></i> Dashboard</a>
            </li>
            <li>
                <a href="applications.php" class="nav-link"><i class="fa-solid fa-file-invoice me-2"></i> Applications</a>
            </li>
            <li>
                <a href="scholarships.php" class="nav-link"><i class="fa-solid fa-money-check-dollar me-2"></i> Scholarships</a>
            </li>
            <li>
                <a href="documents.php" class="nav-link"><i class="fa-solid fa-clipboard-list me-2"></i> Documents</a>
            </li>
            <li>
                <a href="cv_builder.php" class="nav-link"><i class="fa-solid fa-briefcase me-2"></i> CV Builder</a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="logout.php" class="d-flex align-items-center text-white text-decoration-none bg-danger p-2 rounded justify-content-center">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-gray-800">Welcome back, <?= htmlspecialchars($_SESSION['name']); ?>! 👋</h2>
        </div>

        <div class="row g-4">
            <!-- Applications Card -->
            <div class="col-xl-4 col-md-6 border-0">
                <div class="card h-100 py-2 border-left-primary shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Applications</div>
                                <div class="h5 mb-0 fw-bold text-gray-800"><?= $total_apps; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coming soon widgets -->
            <div class="col-xl-4 col-md-6 border-0">
                <div class="card h-100 py-2 border-left-success shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">Pending Documents</div>
                                <div class="h5 mb-0 fw-bold text-gray-800">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4 col-md-6 border-0">
                <div class="card h-100 py-2 border-left-info shadow-sm border-0 bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-uppercase mb-1">Upcoming Deadlines</div>
                                <div class="h5 mb-0 fw-bold">None soon</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
               <div class="card shadow-sm border-0 p-4">
                   <h5 class="fw-bold mb-3">Recent Applications</h5>
                   <p class="text-muted">You haven't added any applications yet. <a href="#">Add your first university application</a> to start tracking!</p>
               </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
