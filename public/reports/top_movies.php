<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/permissions.php';
require_role(['admin', 'manager']);
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/db.php';

$stmt = $pdo->query("
    SELECT m.title, COUNT(r.id) AS rental_count
    FROM rentals r
    JOIN movies m ON r.movie_id = m.id
    GROUP BY m.id
    ORDER BY rental_count DESC
");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Top Rented Movies</h1>
<a href="/reports.php" class="back-btn">← Back to Reports</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Movie</th>
        <th>Total Rentals</th>
    </tr>

    <?php foreach ($rows as $r): ?>
    <tr>
        <td><?= $r['title'] ?></td>
        <td><?= $r['rental_count'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>