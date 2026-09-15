<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$users = $pdo->query("SELECT id, username, role FROM users ORDER BY username ASC")
             ->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Manage Users</h1>
<a href="dashboard.php" class="back-btn">← Back to Dashboard</a>

<br><br>

<a href="add_user.php" class="card-btn">Add New User</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= $u['id'] ?></td>
        <td><?= htmlspecialchars($u['username']) ?></td>
        <td><?= $u['role'] ?></td>
        <td>
            <a href="edit_user.php?id=<?= $u['id'] ?>">Edit</a> |
            <a href="delete_user.php?id=<?= $u['id'] ?>"
               onclick="return confirm('Delete this user?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
