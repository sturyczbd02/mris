<?php
require_once __DIR__ . '/../includes/auth.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Welcome, <?= $_SESSION['username'] ?>!</h1>

<ul>
    <li><a href="customers.php">Manage Customers</a></li>
    <li><a href="movies.php">Manage Movies</a></li>
    <li><a href="rentals.php">Manage Rentals</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

</body>
</html>