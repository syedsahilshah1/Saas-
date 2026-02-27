<?php
require_once 'core/functions.php';
requireLogin();

$user_id = $_SESSION['user_id'];

// Default missing documents config for any student
$default_docs = [
    'Passport', 
    'Transcripts (High School / BS)', 
    'Degree Certificate', 
    'CV / Resume', 
    'Statement of Purpose (SOP)', 
    'Letters of Recommendation (x2)', 
    'English Proficiency (IELTS/TOEFL/Duolingo)'
];

// Check if user has initialized their documents
$stmt = $pdo->prepare("SELECT COUNT(*) FROM documents WHERE user_id = ?");
$stmt->execute([$user_id]);
if ($stmt->fetchColumn() == 0) {
    // Insert default documents for the new user
    $insertDoc = $pdo->prepare("INSERT INTO documents (user_id, document_name, is_completed) VALUES (?, ?, 0)");
    foreach ($default_docs as $doc) {
        $insertDoc->execute([$user_id, $doc]);
    }
}

// Handle checkbox toggles securely
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doc_id'])) {
    $doc_id = (int)$_POST['doc_id'];
    $is_completed = (isset($_POST['is_completed']) && $_POST['is_completed'] == '1') ? 1 : 0;
    
    $updateStmt = $pdo->prepare("UPDATE documents SET is_completed = ? WHERE id = ? AND user_id = ?");
    $updateStmt->execute([$is_completed, $doc_id, $user_id]);
    
    // Return early if AJAX (better UX), or redirect back if normal post
    header("Location: documents.php");
    exit;
}

// Fetch user's checklist
$stmt = $pdo->prepare("SELECT * FROM documents WHERE user_id = ? ORDER BY id ASC");
$stmt->execute([$user_id]);
$documents = $stmt->fetchAll();

$completed_count = count(array_filter($documents, fn($d) => $d['is_completed'] == 1));
$total_docs = count($documents);
$progress = $total_docs > 0 ? round(($completed_count / $total_docs) * 100) : 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Checklist - Roadmap SaaS</title>
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
            <li><a href="scholarships.php" class="nav-link"><i class="fa-solid fa-money-check-dollar me-2"></i> Scholarships</a></li>
            <li><a href="documents.php" class="nav-link active"><i class="fa-solid fa-clipboard-list me-2"></i> Documents</a></li>
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
            <h2 class="h3 mb-0 text-gray-800">My Document Master Checklist</h2>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="fw-bold">Overall Progress (<?= $completed_count ?>/<?= $total_docs ?> Documents Ready)</h5>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"><?= $progress ?>%</div>
                    </div>
                </div>

                <ul class="list-group list-group-flush mt-3">
                    <?php foreach ($documents as $doc): ?>
                        <li class="list-group-item bg-transparent px-0 border-bottom py-3 d-flex justify-content-between align-items-center">
                            <span class="fs-5 <?= $doc['is_completed'] ? 'text-decoration-line-through text-muted' : 'text-dark fw-medium' ?>">
                                <?= htmlspecialchars($doc['document_name']) ?>
                            </span>
                            <form action="documents.php" method="POST" class="d-inline m-0 p-0">
                                <input type="hidden" name="doc_id" value="<?= $doc['id'] ?>">
                                <!-- hidden input so unchecked box sends 0 -->
                                <input type="hidden" name="is_completed" value="<?= $doc['is_completed'] ? 0 : 1 ?>">
                                <button type="submit" class="btn btn-<?= $doc['is_completed'] ? 'success' : 'outline-secondary' ?> rounded-circle">
                                    <i class="fa-solid <?= $doc['is_completed'] ? 'fa-check' : 'fa-hourglass' ?>"></i>
                                </button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
