<?php
session_start();

// If session exists → go to dashboard
// If not → go to login
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;