<?php

function validateUsername($username) {
    $username = trim($username);
    if (empty($username)) {
        return "Username is required.";
    }
    if (strlen($username) < 3 || strlen($username) > 20) {
        return "Username must be between 3 and 20 characters.";
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        return "Username can only contain letters, numbers, and underscores.";
    }
    return null;
}

function validateEmail($email) {
    $email = trim($email);
    if (empty($email)) {
        return "Email is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Please enter a valid email address.";
    }
    return null;
}

function validatePassword($password) {
    if (empty($password)) {
        return "Password is required.";
    }
    if (strlen($password) < 6) {
        return "Password must be at least 6 characters.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        return "Password must contain at least one number.";
    }
    return null;
}

