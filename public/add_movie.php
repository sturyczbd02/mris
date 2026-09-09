<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);
require_once __DIR__ . '/../includes/header.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $year = $_POST['release_year'];
    $rating = $_POST['rating'];
    $stock = $_POST['stock_count'];

    $stmt = $pdo->prepare("
        INSERT INTO movies (title, genre, release_year, rating, stock_count)
        VALUES (:title, :genre, :year, :rating, :stock)
    ");

    $stmt->execute([
        ':title' => $title,
        ':genre' => $genre,
        ':year'  => $year,
        ':rating'=> $rating,
        ':stock' => $stock
    ]);

    $message = "Movie added successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Movie</title>
</head>
<body>

<h1>Add New Movie</h1>

<?php if ($message): ?>
    <p style="color: green;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre"><br><br>

    <label>Release Year:</label><br>
    <input type="number" name="release_year"><br><br>

    <label>Rating:</label><br>
    <input type="text" name="rating"><br><br>

    <label>Stock Count:</label><br>
    <input type="number" name="stock_count" value="1"><br><br>

    <button type="submit">Add Movie</button>
</form>

<br>
<a href="movies.php">Back to Movie List</a>

</body>
</html>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>