<?php
require_once __DIR__ . '/../includes/db.php';

$stmt = $pdo->query("SELECT * FROM customers ORDER BY last_name ASC");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Customers</title>
</head>
<body>
    <h1>Customer List</h1>

    <a href="add_customer.php">Add New Customer</a>
    <br><br>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($customers as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['first_name'] . " " . $c['last_name'] ?></td>
            <td><?= $c['email'] ?></td>
            <td><?= $c['phone'] ?></td>
            <td>
                <a href="edit_customer.php?id=<?= $c['id'] ?>">Edit</a> |
                <a href="delete_customer.php?id=<?= $c['id'] ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
