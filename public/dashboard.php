<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';
?>

<h1>Welcome, <?= $_SESSION['username'] ?>!</h1>

<ul>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <li><a href="/customers.php">Manage Customers</a></li>
        <li><a href="/movies.php">Manage Movies</a></li>
        <li><a href="/users.php">Manage Users</a></li>
    <?php endif; ?>

    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
        <li><a href="/rentals.php">Manage Rentals</a></li>
        <li><a href="/reports.php">Reports</a></li>
    <?php endif; ?>

    <?php if ($_SESSION['role'] === 'employee'): ?>
        <li><a href="/rentals.php">Process Rentals</a></li>
    <?php endif; ?>

    <li><a href="/logout.php">Logout</a></li>
</ul>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>