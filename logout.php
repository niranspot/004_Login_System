<?php
session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Do NOT delete cookies - theme and username cookies remain
// for convenience on next visit (as per spec)

// Redirect to login
header('Location: login.php');
exit;