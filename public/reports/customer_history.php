<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/permissions.php';
require_role(['admin', 'manager']);
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../includes/db.php';

$customers = $pdo->query("SELECT id, first_name, last_name FROM customers ORDER BY last_name")
                 ->fetchAll(PDO::FETCH_ASSOC);

$rows = [];

if (isset($_GET['customer_id'])) {
    $stmt = $pdo->prepare("
        SELECT r.*, m.title
        FROM rentals r
        JOIN movies m ON r.movie_id = m.id
        WHERE r.customer_id = :cid
        ORDER BY r.rental_date DESC
    ");
    $stmt->execute([':cid' => $_GET['customer_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<h1>Customer Rental History</h1>
<a href="reports.php" class="back-btn">← Back to Reports</a>

<form method="GET">
    <label>Select Customer:</label><br>
    <select name="customer_id" required>
        <option value="">Choose...</option>
        <?php foreach ($customers as $c): ?>
            <option value="<?= $c['id'] ?>">
                <?= $c['first_name'] . " " . $c['last_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">View History</button>
</form>

<?php if ($rows): ?>
<br>
<table border="1" cellpadding="8">
    <tr>
        <th>Movie</th>
        <th>Rented On</th>
        <th>Returned On</th>
        <th>Status</th>
    </tr>

    <?php foreach ($rows as $r): ?>
    <tr>
        <td><?= $r['title'] ?></td>
        <td><?= $r['rental_date'] ?></td>
        <td><?= $r['return_date'] ?: '-' ?></td>
        <td><?= $r['status'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>