<?php
require_once 'core/functions.php';
requireLogin();

// In MVP Phase we simply generate the HTML content of the CV and display it.
// Converting actually to PDF would require a library like TCPDF or mPDF,
// Alternatively you can use javascript `window.print()` to save as PDF.

$cv_generated = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitizeInput($_POST['full_name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $summary = sanitizeInput($_POST['summary']);
    $education = sanitizeInput($_POST['education']);
    $experience = sanitizeInput($_POST['experience']);
    $skills = sanitizeInput($_POST['skills']);
    
    $cv_generated = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Builder - Roadmap SaaS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Printable CV Styling */
        @media print {
            body * {
                visibility: hidden;
            }
            #printableCV, #printableCV * {
                visibility: visible;
            }
            #printableCV {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white;
                padding: 20px;
            }
        }
    </style>
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
            <li><a href="documents.php" class="nav-link"><i class="fa-solid fa-clipboard-list me-2"></i> Documents</a></li>
            <li><a href="cv_builder.php" class="nav-link active"><i class="fa-solid fa-briefcase me-2"></i> CV Builder</a></li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="logout.php" class="d-flex align-items-center text-white text-decoration-none bg-danger p-2 rounded justify-content-center">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1 bg-light p-4">
        
        <?php if (!$cv_generated): ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0 text-gray-800">Europass Style CV Builder</h2>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form method="POST">
                        <h5 class="mb-3 border-bottom pb-2">Personal Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_SESSION['name'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Professional Summary</label>
                            <textarea name="summary" class="form-control" rows="3" required></textarea>
                        </div>

                        <h5 class="mb-3 border-bottom pb-2">Experience & Education</h5>
                        <div class="mb-3">
                            <label class="form-label">Education (List recent first)</label>
                            <textarea name="education" class="form-control" rows="4" placeholder="e.g. BS Computer Science - FAST NUCES - (2020-2024)" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Work Experience / Internships</label>
                            <textarea name="experience" class="form-control" rows="4" placeholder="e.g. Software Engineer Intern - ABC Tech - (2023)" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Top Skills (Comma separated)</label>
                            <input type="text" name="skills" class="form-control" placeholder="e.g. PHP, Laravel, Python, Leadership" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg"><i class="fa-solid fa-file-pdf me-2"></i> Generate CV</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0 text-gray-800">Your Generated CV</h2>
                <div>
                    <a href="cv_builder.php" class="btn btn-outline-secondary me-2"><i class="fa-solid fa-arrow-left me-1"></i> Edit</a>
                    <button onclick="window.print()" class="btn btn-success"><i class="fa-solid fa-download me-1"></i> Save as PDF</button>
                </div>
            </div>

            <!-- Print Area -->
            <div id="printableCV" class="bg-white p-5 shadow-sm border mt-3 mx-auto" style="max-width: 800px;">
                <h1 class="font-weight-bold text-dark border-bottom pb-3 mb-4"><?= htmlspecialchars($full_name) ?></h1>
                <p class="mb-4 text-muted"><i class="fa-solid fa-envelope me-2"></i> <?= htmlspecialchars($email) ?> | <i class="fa-solid fa-phone me-2"></i> <?= htmlspecialchars($phone) ?></p>

                <h4 class="text-primary mt-4 mb-3 border-bottom pb-1">Summary</h4>
                <p><?= nl2br(htmlspecialchars($summary)) ?></p>

                <h4 class="text-primary mt-4 mb-3 border-bottom pb-1">Education</h4>
                <p><?= nl2br(htmlspecialchars($education)) ?></p>

                <h4 class="text-primary mt-4 mb-3 border-bottom pb-1">Experience</h4>
                <p><?= nl2br(htmlspecialchars($experience)) ?></p>

                <h4 class="text-primary mt-4 mb-3 border-bottom pb-1">Top Skills</h4>
                <p><?= nl2br(htmlspecialchars($skills)) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
