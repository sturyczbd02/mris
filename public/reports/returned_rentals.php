<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/permissions.php';
require_role(['admin', 'manager']);
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/db.php';

$stmt = $pdo->query("
    SELECT r.id, r.rental_date, r.return_date,
           c.first_name, c.last_name,
           m.title
    FROM rentals r
    JOIN customers c ON r.customer_id = c.id
    JOIN movies m ON r.movie_id = m.id
    WHERE r.status = 'returned'
    ORDER BY r.return_date DESC
");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Returned Rentals</h1>
<a href="/reports.php" class="back-btn">← Back to Reports</a>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Movie</th>
        <th>Rented On</th>
        <th>Returned On</th>
    </tr>

    <?php foreach ($rows as $r): ?>
    <tr>
        <td><?= $r['id'] ?></td>
        <td><?= $r['first_name'] . " " . $r['last_name'] ?></td>
        <td><?= $r['title'] ?></td>
        <td><?= $r['rental_date'] ?></td>
        <td><?= $r['return_date'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>