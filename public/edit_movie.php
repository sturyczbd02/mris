<?php
require_once __DIR__ . '/../includes/db.php';

if (!isset($_GET['id'])) {
    die("Movie ID missing.");
}

$id = $_GET['id'];
$message = "";

// Fetch movie
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = :id");
$stmt->execute([':id' => $id]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$movie) {
    die("Movie not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $year = $_POST['release_year'];
    $rating = $_POST['rating'];
    $stock = $_POST['stock_count'];

    $update = $pdo->prepare("
        UPDATE movies
        SET title = :title, genre = :genre, release_year = :year,
            rating = :rating, stock_count = :stock
        WHERE id = :id
    ");

    $update->execute([
        ':title' => $title,
        ':genre' => $genre,
        ':year'  => $year,
        ':rating'=> $rating,
        ':stock' => $stock,
        ':id'    => $id
    ]);

    $message = "Movie updated successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Movie</title>
</head>
<body>

<h1>Edit Movie</h1>

<?php if ($message): ?>
    <p style="color: green;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= $movie['title'] ?>" required><br><br>

    <label>Genre:</label><br>
    <input type="text" name="genre" value="<?= $movie['genre'] ?>"><br><br>

    <label>Release Year:</label><br>
    <input type="number" name="release_year" value="<?= $movie['release_year'] ?>"><br><br>

    <label>Rating:</label><br>
    <input type="text" name="rating" value="<?= $movie['rating'] ?>"><br><br>

    <label>Stock Count:</label><br>
    <input type="number" name="stock_count" value="<?= $movie['stock_count'] ?>"><br><br>

    <button type="submit">Save Changes</button>
</form>

<br>
<a href="movies.php">Back to Movie List</a>

</body>
</html>