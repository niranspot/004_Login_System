<?php
session_start();

// Read cookies
$rememberedUsername = isset($_COOKIE['remember_username']) ? $_COOKIE['remember_username'] : '';
$userTheme = isset($_COOKIE['user_theme']) ? $_COOKIE['user_theme'] : 'light';

// Pull errors from session (set by auth.php) then clear them
$errors   = isset($_SESSION['login_errors']) ? $_SESSION['login_errors'] : [];
$oldInput = isset($_SESSION['old_input'])    ? $_SESSION['old_input']    : [];
unset($_SESSION['login_errors'], $_SESSION['old_input']);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="<?= $userTheme === 'dark' ? 'dark' : 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-body-tertiary">

<div class="card shadow p-4" style="width: 100%; max-width: 440px;">
    <h3 class="card-title mb-1">Welcome back</h3>
    <p class="text-muted mb-4 small">Sign in to your account</p>

    <!-- General error (wrong credentials) -->
    <?php if (!empty($errors['general'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>

    <form action="auth.php" method="POST" novalidate>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email"
                class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                placeholder="you@example.com"
                value="<?= htmlspecialchars($oldInput['email'] ?? '') ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username"
                class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                placeholder="your_username"
                value="<?= htmlspecialchars($oldInput['username'] ?? $rememberedUsername) ?>">
            <?php if (isset($errors['username'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['username']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password"
                class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                placeholder="••••••••">
            <?php if (isset($errors['password'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
        </div>

        <!-- Remember Me -->
        <div class="mb-4 form-check">
            <input type="checkbox" name="remember_me" id="remember_me" class="form-check-input"
                <?= !empty($rememberedUsername) ? 'checked' : '' ?>>
            <label for="remember_me" class="form-check-label">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Sign In</button>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>