<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin', 'manager']);
require_once __DIR__ . '/../includes/header.php';

$stmt = $pdo->query("SELECT * FROM movies ORDER BY title ASC");
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Movies</title>
</head>
<body>

<h1>Movie Inventory</h1>
<a href="dashboard.php" class="back-btn">← Back to Dashboard</a>

<br><br>

<a href="add_movie.php">Add New Movie</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Genre</th>
        <th>Year</th>
        <th>Rating</th>
        <th>Stock</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($movies as $m): ?>
    <tr>
        <td><?= $m['id'] ?></td>
        <td><?= $m['title'] ?></td>
        <td><?= $m['genre'] ?></td>
        <td><?= $m['release_year'] ?></td>
        <td><?= $m['rating'] ?></td>
        <td><?= $m['stock_count'] ?></td>
        <td>
            <a href="edit_movie.php?id=<?= $m['id'] ?>">Edit</a> |
            <a href="delete_movie.php?id=<?= $m['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>