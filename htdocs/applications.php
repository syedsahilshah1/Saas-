<?php
require_once 'core/functions.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM applications WHERE id = ? AND user_id = ?");
    $stmt->execute([$delete_id, $user_id]);
    header("Location: applications.php");
    exit;
}

// Fetch applications
$stmt = $pdo->prepare("SELECT * FROM applications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$applications = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications - Roadmap SaaS</title>
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
                <a href="dashboard.php" class="nav-link"><i class="fa-solid fa-house me-2"></i> Dashboard</a>
            </li>
            <li>
                <a href="applications.php" class="nav-link active"><i class="fa-solid fa-file-invoice me-2"></i> Applications</a>
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
            <h2 class="h3 mb-0 text-gray-800">My Applications</h2>
            <a href="add_application.php" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Add Application</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <?php if (count($applications) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>University</th>
                                    <th>Program</th>
                                    <th>Country</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $app): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($app['university_name']) ?></td>
                                        <td><?= htmlspecialchars($app['program_name']) ?></td>
                                        <td><?= htmlspecialchars($app['country']) ?></td>
                                        <td><?= $app['deadline'] ? date('M d, Y', strtotime($app['deadline'])) : 'Not set' ?></td>
                                        <td>
                                            <span class="badge bg-<?= $app['status'] == 'Accepted' ? 'success' : ($app['status'] == 'Rejected' ? 'danger' : 'info') ?>">
                                                <?= htmlspecialchars($app['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="edit_application.php?id=<?= $app['id'] ?>" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-pen"></i></a>
                                            <a href="applications.php?delete=<?= $app['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                        <h5>No applications yet</h5>
                        <p class="text-muted">Start tracking your university applications by adding your first one.</p>
                        <a href="add_application.php" class="btn btn-primary mt-2">Add First Application</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
