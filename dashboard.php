<?php
session_start();

// Protect dashboard - redirect if no session
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Read session data
$username = $_SESSION['username'];
$email    = $_SESSION['email'];
$theme    = $_SESSION['theme'];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="<?= $theme === 'dark' ? 'dark' : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <?php if ($theme === 'warm'): ?>
    <style>
        body { background-color: #fdf6ec !important; }
        .card { background-color: #fff8f0 !important; border-color: #e8c99a !important; }
        .navbar { background-color: #c8762b !important; }
        .badge-theme { background-color: #c8762b !important; }
    </style>
    <?php endif; ?>

</head>
<body class="bg-body-tertiary min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand px-4 
        <?= $theme === 'dark' ? 'navbar-dark bg-dark' : ($theme === 'warm' ? '' : 'navbar-light bg-primary') ?>">
        <span class="navbar-brand text-white fw-bold">Capmind</span>
        <div class="ms-auto">
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mt-5">

        <!-- Welcome card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">Welcome, <strong><?= htmlspecialchars($username) ?></strong>! 👋</h4>
                <p class="text-muted mb-0">You are successfully logged in.</p>
            </div>
        </div>

        <!-- Session details card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-semibold">Session Details</div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 140px;">User ID</th>
                            <td><?= htmlspecialchars($_SESSION['user_id']) ?></td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td><?= htmlspecialchars($username) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= htmlspecialchars($email) ?></td>
                        </tr>
                        <tr>
                            <th>Theme</th>
                            <td>
                                <span class="badge badge-theme
                                    <?= $theme === 'dark' ? 'bg-dark border' : ($theme === 'warm' ? '' : 'bg-primary') ?>">
                                    <?= ucfirst($theme) ?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cookie info card -->
        <div class="card shadow-sm">
            <div class="card-header fw-semibold">Cookie Status</div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 180px;">remember_username</th>
                            <td>
                                <?php if (isset($_COOKIE['remember_username'])): ?>
                                    <span class="badge bg-success">Set: <?= htmlspecialchars($_COOKIE['remember_username']) ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Not set</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>user_theme</th>
                            <td>
                                <?php if (isset($_COOKIE['user_theme'])): ?>
                                    <span class="badge bg-success">Set: <?= htmlspecialchars($_COOKIE['user_theme']) ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Not set</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>