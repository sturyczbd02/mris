<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin', 'manager']);
require_once __DIR__ . '/../includes/header.php';
?>

<h1>Reports</h1>

<div class="dashboard-grid">

    <div class="card">
        <h2>Active Rentals</h2>
        <p>View all currently rented movies.</p>
        <a href="/reports/active_rentals.php" class="card-btn">Open Report</a>
    </div>

    <div class="card">
        <h2>Returned Rentals</h2>
        <p>View all completed rental transactions.</p>
        <a href="/reports/returned_rentals.php" class="card-btn">Open Report</a>
    </div>

    <div class="card">
        <h2>Top Rented Movies</h2>
        <p>See which movies are rented the most.</p>
        <a href="/reports/top_movies.php" class="card-btn">Open Report</a>
    </div>

    <div class="card">
        <h2>Customer Rental History</h2>
        <p>Search rentals by customer.</p>
        <a href="/reports/customer_history.php" class="card-btn">Open Report</a>
    </div>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>