<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Brew City Rentals</title>
    <link rel="stylesheet" href="/mris/public/assets/css/style.css">
</head>
<body>

<!-- Top Navigation Bar -->
<nav class="top-nav">
    <div class="nav-left">
        <a class="nav-brand" href="/mris/public/dashboard.php">Brew City Rentals</a>
    </div>

    <div class="nav-right">
        <?php if (isset($_SESSION['username'])): ?>
            <span class="nav-user">Logged in as <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="/mris/public/logout.php" class="nav-link">Logout</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Main Page Container -->
<div class="main-container">