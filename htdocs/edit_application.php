<?php
require_once 'core/functions.php';
requireLogin();

$error = ''; $success = '';
$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: applications.php");
    exit;
}

$app_id = (int)$_GET['id'];

// Prevent user from editing other people's applications
$stmt = $pdo->prepare("SELECT * FROM applications WHERE id = ? AND user_id = ?");
$stmt->execute([$app_id, $user_id]);
$app = $stmt->fetch();

if (!$app) {
    die("Application not found or unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uni = sanitizeInput($_POST['university_name']);
    $prog = sanitizeInput($_POST['program_name']);
    $country = sanitizeInput($_POST['country']);
    $deadline = !empty($_POST['deadline']) ? $_POST['deadline'] : null;
    $status = sanitizeInput($_POST['status']);
    $notes = sanitizeInput($_POST['notes']);

    if (empty($uni) || empty($prog)) {
        $error = "University and Program name are required.";
    } else {
        $stmt = $pdo->prepare("UPDATE applications SET university_name = ?, program_name = ?, country = ?, deadline = ?, status = ?, notes = ? WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$uni, $prog, $country, $deadline, $status, $notes, $app_id, $user_id])) {
            header("Location: applications.php");
            exit;
        } else {
            $error = "Failed to update application.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Application - Roadmap SaaS</title>
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
            <li><a href="applications.php" class="nav-link active"><i class="fa-solid fa-file-invoice me-2"></i> Applications</a></li>
            <li><a href="scholarships.php" class="nav-link"><i class="fa-solid fa-money-check-dollar me-2"></i> Scholarships</a></li>
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
            <h2 class="h3 mb-0 text-gray-800">Edit Application</h2>
            <a href="applications.php" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
                
                <form method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">University Name <span class="text-danger">*</span></label>
                            <input type="text" name="university_name" class="form-control" value="<?= htmlspecialchars($app['university_name']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Program Name <span class="text-danger">*</span></label>
                            <input type="text" name="program_name" class="form-control" value="<?= htmlspecialchars($app['program_name']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($app['country']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Deadline</label>
                            <input type="date" name="deadline" class="form-control" value="<?= htmlspecialchars($app['deadline'] ?? '') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Planning" <?= $app['status'] == 'Planning' ? 'selected' : '' ?>>Planning</option>
                                <option value="Applied" <?= $app['status'] == 'Applied' ? 'selected' : '' ?>>Applied</option>
                                <option value="Interview" <?= $app['status'] == 'Interview' ? 'selected' : '' ?>>Interview</option>
                                <option value="Accepted" <?= $app['status'] == 'Accepted' ? 'selected' : '' ?>>Accepted</option>
                                <option value="Rejected" <?= $app['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" name="notes" rows="3"><?= htmlspecialchars($app['notes']) ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-check me-1"></i> Update Application</button>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
