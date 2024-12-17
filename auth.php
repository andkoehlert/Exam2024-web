<?php
// auth.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkIfLoggedIn($requiredRole = null) {
    // Check if the user is logged in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        // If not logged in, redirect to the login page
        header("Location: /login");
        exit;
    }

    // If a specific role is required, check the user's role
    if ($requiredRole !== null && (!isset($_SESSION["role"]) || $_SESSION["role"] !== $requiredRole)) {
        header("Location: /explore");
        exit;
    }
}
