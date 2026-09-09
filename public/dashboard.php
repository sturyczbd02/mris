<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin','manager','employee']);
require_once __DIR__ . '/../includes/header.php';
?>

<div class="dashboard-container">
    <div class="dashboard-card">
        <h1 class="dashboard-title">Dashboard</h1>
        <p class="dashboard-subtitle">Welcome back, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

        <div class="dashboard-grid">

            <div class="card">
                <h2>Customers</h2>
                <p>Total: <?= $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn() ?></p>
                <a href="/customers.php" class="card-btn">Manage Customers</a>
            </div>

            <div class="card">
                <h2>Movies</h2>
                <p>Total: <?= $pdo->query("SELECT COUNT(*) FROM movies")->fetchColumn() ?></p>
                <a href="/movies.php" class="card-btn">Manage Movies</a>
            </div>

            <div class="card">
                <h2>Rentals</h2>
                <p>Active: <?= $pdo->query("SELECT COUNT(*) FROM rentals WHERE status='out'")->fetchColumn() ?></p>
                <p>Returned: <?= $pdo->query("SELECT COUNT(*) FROM rentals WHERE status='returned'")->fetchColumn() ?></p>
                <a href="/rentals.php" class="card-btn">View Rentals</a>
                <a href="/new_rental.php" class="card-btn">New Rental</a>
            </div>

            <div class="card">
                <h2>Reports</h2>
                <p>View rental history and analytics.</p>
                <a href="/reports.php" class="card-btn">Open Reports</a>
            </div>

            <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="card">
                <h2>User Accounts</h2>
                <p>Manage system users and roles.</p>
                <a href="/users.php" class="card-btn">Manage Users</a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>