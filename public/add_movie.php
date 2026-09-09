<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);
require_once __DIR__ . '/../includes/header.php';

$message = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $year = trim($_POST['year']);
    $rating = trim($_POST['rating']);
    $stock = trim($_POST['stock']);

    // Validation
    if (empty($title)) $errors[] = "Movie title is required.";
    if (empty($genre)) $errors[] = "Genre is required.";
    if (empty($year)) $errors[] = "Year is required.";
    if (empty($rating)) $errors[] = "Rating is required.";
    if ($stock === "") {
        $errors[] = "Stock is required.";
    } elseif (!ctype_digit($stock) || $stock < 0) {
        $errors[] = "Stock must be a non-negative number.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO movies (title, genre, year, rating, stock_count)
            VALUES (:title, :genre, :year, :rating, :stock_count)
        ");
        $stmt->execute([
            ':title' => $title,
            ':genre' => $genre,
            ':year' => $year,
            ':rating' => $rating,
            ':stock_count' => $stock
        ]);

        $message = "Movie added successfully!";
    }
}
?>

<h1>Add New Movie</h1>

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
    <input type="text" name="title" required><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre" required><br><br>

    <label>Year:</label><br>
    <input type="number" name="year" min="1900" max="2099" required><br><br>

    <label>Rating:</label><br>
    <input type="text" name="rating" placeholder="e.g. PG-13" required><br><br>

    <label>Stock:</label><br>
    <input type="number" name="stock" min="0" required><br><br>

    <button type="submit">Add Movie</button>
</form>

<br>
<a href="movies.php">Back to Movie List</a>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>