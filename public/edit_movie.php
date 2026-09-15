<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin', 'manager']);
require_once __DIR__ . '/../includes/header.php';

if (!isset($_GET['id'])) die("Movie ID missing.");
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = :id");
$stmt->execute([':id' => $id]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$movie) die("Movie not found.");

$message = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $stock = trim($_POST['stock']);

    // Validation
    if (empty($title)) $errors[] = "Movie title is required.";
    if (empty($genre)) $errors[] = "Genre is required.";

    if ($stock === "") {
        $errors[] = "Stock is required.";
    } elseif (!ctype_digit($stock) || $stock < 0) {
        $errors[] = "Stock must be a non-negative number.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            UPDATE movies
            SET title = :title, genre = :genre, stock = :stock
            WHERE id = :id
        ");
        $stmt->execute([
            ':title' => $title,
            ':genre' => $genre,
            ':stock' => $stock,
            ':id' => $id
        ]);

        $message = "Movie updated successfully!";
    }
}
?>

<h1>Edit Movie</h1>

<?php if (!empty($errors)): ?>
<div class="error-box">
    <?php foreach ($errors as $e): ?>
        <p><?= htmlspecialchars($e) ?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if ($message): ?>
<div class="success-box">
    <p><?= htmlspecialchars($message) ?></p>
</div>
<?php endif; ?>

<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre" value="<?= htmlspecialchars($movie['genre']) ?>" required><br><br>

    <label>Stock:</label><br>
    <input type="number" name="stock" min="0" value="<?= htmlspecialchars($movie['stock']) ?>" required><br><br>

    <button type="submit">Save Changes</button>
</form>

<br>
<a href="movies.php">Back to Movie List</a>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>