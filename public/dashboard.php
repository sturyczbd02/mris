<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin', 'manager', 'employee']);
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

// Fetch metrics
$totalCustomers = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$totalMovies = $pdo->query("SELECT COUNT(*) FROM movies")->fetchColumn();
$activeRentals = $pdo->query("SELECT COUNT(*) FROM rentals WHERE status='out'")->fetchColumn();
$returnedRentals = $pdo->query("SELECT COUNT(*) FROM rentals WHERE status='returned'")->fetchColumn();
?>

<h1>Dashboard</h1>
<p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

<div class="dashboard-grid">

    <!-- Customers -->
    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
    <div class="card">
        <h2>Customers</h2>
        <p>Total: <?= $totalCustomers ?></p>
        <a href="/customers.php" class="card-btn">Manage Customers</a>
    </div>
    <?php endif; ?>

    <!-- Movies -->
    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
    <div class="card">
        <h2>Movies</h2>
        <p>Total: <?= $totalMovies ?></p>
        <a href="/movies.php" class="card-btn">Manage Movies</a>
    </div>
    <?php endif; ?>

    <!-- Rentals -->
    <div class="card">
        <h2>Rentals</h2>
        <p>Active: <?= $activeRentals ?></p>
        <p>Returned: <?= $returnedRentals ?></p>
        <a href="/rentals.php" class="card-btn">View Rentals</a>
        <a href="/new_rental.php" class="card-btn">New Rental</a>
    </div>

    <!-- Reports -->
    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager'): ?>
    <div class="card">
        <h2>Reports</h2>
        <p>View rental history and analytics.</p>
        <a href="/reports.php" class="card-btn">Open Reports</a>
    </div>
    <?php endif; ?>

    <!-- User Management -->
    <?php if ($_SESSION['role'] === 'admin'): ?>
    <div class="card">
        <h2>User Accounts</h2>
        <p>Manage system users and roles.</p>
        <a href="/users.php" class="card-btn">Manage Users</a>
    </div>
    <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>