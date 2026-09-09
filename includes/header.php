<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>MRIS</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="navbar">
    <a href="/dashboard.php">Dashboard</a>
    <a href="/customers.php">Customers</a>
    <a href="/movies.php">Movies</a>
    <a href="/rentals.php">Rentals</a>
    <a href="/logout.php">Logout</a>
</div>

<div class="content">