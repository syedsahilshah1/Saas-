<?php
require_once 'core/functions.php';
requireLogin();

// Fetch scholarships
$stmt = $pdo->prepare("SELECT * FROM scholarships ORDER BY deadline ASC");
$stmt->execute();
$scholarships = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarships - Roadmap SaaS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="d-flex h-100">
    <div class="sidebar p-3 text-white" style="width: 250px;">
        <h4 class="mb-4 d-flex align-items-center"><i class="fa-solid fa-graduation-cap me-2 text-primary"></i> <span class="fs-5 fw-bold">Roadmap Saas</span></h4>
        <hr class="text-secondary">
        <ul class="nav flex-column mb-auto">
            <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="fa-solid fa-house me-2"></i> Dashboard</a></li>
            <li><a href="applications.php" class="nav-link"><i class="fa-solid fa-file-invoice me-2"></i> Applications</a></li>
            <li><a href="scholarships.php" class="nav-link active"><i class="fa-solid fa-money-check-dollar me-2"></i> Scholarships</a></li>
            <li><a href="documents.php" class="nav-link"><i class="fa-solid fa-clipboard-list me-2"></i> Documents</a></li>
            <li><a href="cv_builder.php" class="nav-link"><i class="fa-solid fa-briefcase me-2"></i> CV Builder</a></li>
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
            <h2 class="h3 mb-0 text-gray-800">Scholarships Database</h2>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fa-solid fa-info-circle me-1"></i> These are global scholarships sourced for you. Check deadlines carefully!
                </div>
                
                <?php if (count($scholarships) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Scholarship Name</th>
                                    <th>Country</th>
                                    <th>Deadline</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($scholarships as $sch): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($sch['name']) ?></td>
                                        <td><?= htmlspecialchars($sch['country']) ?></td>
                                        <td><?= $sch['deadline'] ? date('M d, Y', strtotime($sch['deadline'])) : 'Open year round' ?></td>
                                        <td><a href="<?= htmlspecialchars($sch['link']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Visit <i class="fa-solid fa-external-link-alt ms-1"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-money-bill-wave fa-3x text-muted mb-3"></i>
                        <h5>No scholarships loaded yet</h5>
                        <p class="text-muted">The admin team is adding new opportunities soon.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
