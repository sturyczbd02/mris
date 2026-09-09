<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin', 'manager', 'employee']);
require_once __DIR__ . '/../includes/header.php';

$stmt = $pdo->query("
    SELECT r.*, 
           c.first_name, c.last_name,
           m.title
    FROM rentals r
    JOIN customers c ON r.customer_id = c.id
    JOIN movies m ON r.movie_id = m.id
    ORDER BY r.rental_date DESC
");

$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rentals</title>
</head>
<body>

<h1>Rental Transactions</h1>
<a href="/dashboard.php" class="back-btn">← Back to Dashboard</a>

<br><br>

<a href="new_rental.php">Create New Rental</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Movie</th>
        <th>Rented On</th>
        <th>Returned On</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php foreach ($rentals as $r): ?>
    <tr>
        <td><?= $r['id'] ?></td>
        <td><?= $r['first_name'] . " " . $r['last_name'] ?></td>
        <td><?= $r['title'] ?></td>
        <td><?= $r['rental_date'] ?></td>
        <td><?= $r['return_date'] ?: '-' ?></td>
        <td><?= $r['status'] ?></td>
        <td>
            <?php if ($r['status'] === 'out'): ?>
                <a href="/return_rental.php?id=<?= $r['id'] ?>">Return</a>
            <?php else: ?>
                Returned
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>