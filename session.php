<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page
    header('Location: login.php');
    exit;

}
// Get user data from session
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
