<?php
session_start();
require_once 'include/validation.php';

// Block direct access - only accept POST
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// 1. Receive form data
$email      = trim($_POST['email']    ?? '');
$username   = trim($_POST['username'] ?? '');
$password   = trim($_POST['password'] ?? '');
$rememberMe = isset($_POST['remember_me']);

// 2. Validate inputs
$errors = [];

$emailError    = validateEmail($email);
$usernameError = validateUsername($username);
$passwordError = validatePassword($password);

if ($emailError)    $errors['email']    = $emailError;
if ($usernameError) $errors['username'] = $usernameError;
if ($passwordError) $errors['password'] = $passwordError;

// Validation failed → send errors back to login
if (!empty($errors)) {
    $_SESSION['login_errors'] = $errors;
    $_SESSION['old_input']    = ['email' => $email, 'username' => $username];
    header('Location: login.php');
    exit;
}

// 3. Dummy user data
$users = [
    ['user_id' => 1, 'username' => 'user1', 'email' => 'user1@gmail.com', 'password' => 'User1@123'],
    ['user_id' => 2, 'username' => 'user2', 'email' => 'user2@gmail.com', 'password' => 'User2@123'],
    ['user_id' => 3, 'username' => 'user3', 'email' => 'user3@gmail.com', 'password' => 'User3@123'],
    ['user_id' => 4, 'username' => 'admin', 'email' => 'admin@gmail.com', 'password' => 'Admin@123'],
];

// 4. Authenticate - match all three fields
$matchedUser = null;
foreach ($users as $user) {
    if ($user['username'] === $username &&
        $user['email']    === $email    &&
        $user['password'] === $password) {
        $matchedUser = $user;
        break;
    }
}

// Authentication failed
if (!$matchedUser) {
    $_SESSION['login_errors'] = ['general' => 'Invalid username, email, or password.'];
    $_SESSION['old_input']    = ['email' => $email, 'username' => $username];
    header('Location: login.php');
    exit;
}

// 5. Theme assignment based on user
$themeMap = [
    'user1' => 'dark',
    'user2' => 'warm',
];
$theme = $themeMap[$matchedUser['username']] ?? 'light'; // user3, admin → light

// 6. Store session
$_SESSION['user_id']  = $matchedUser['user_id'];
$_SESSION['username'] = $matchedUser['username'];
$_SESSION['email']    = $matchedUser['email'];
$_SESSION['theme']    = $theme;

// 7. Cookie logic (60 sec for testing)
$expiry = time() + 60;

if ($rememberMe) {
    setcookie('remember_username', $matchedUser['username'], $expiry, '/');
} else {
    setcookie('remember_username', '', time() - 3600, '/'); // clear it
}

// Theme cookie always set
setcookie('user_theme', $theme, $expiry, '/');

// 8. Redirect to dashboard
header('Location: dashboard.php');
exit;