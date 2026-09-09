<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin', 'manager', 'employee']);
require_once __DIR__ . '/../includes/header.php';

$message = "";
$errors = [];

// Fetch customers
$customers = $pdo->query("SELECT id, name FROM customers ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

// Fetch movies (fixed stock_count reference)
$movies = $pdo->query("SELECT id, title, stock_count FROM movies ORDER BY title")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'] ?? '';
    $movie_id = $_POST['movie_id'] ?? '';

    if (empty($customer_id)) $errors[] = "Customer selection is required.";
    if (empty($movie_id)) $errors[] = "Movie selection is required.";

    if (empty($errors)) {
        // Check stock availability
        $stmt = $pdo->prepare("SELECT stock_count FROM movies WHERE id = :id");
        $stmt->execute([':id' => $movie_id]);
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$movie) {
            $errors[] = "Movie not found.";
        } elseif ($movie['stock_count'] <= 0) {
            $errors[] = "This movie is out of stock.";
        } else {
            // Create rental record
            $stmt = $pdo->prepare("
                INSERT INTO rentals (customer_id, movie_id, rental_date)
                VALUES (:customer_id, :movie_id, NOW())
            ");
            $stmt->execute([
                ':customer_id' => $customer_id,
                ':movie_id' => $movie_id
            ]);

            // Decrease stock count
            $stmt = $pdo->prepare("
                UPDATE movies SET stock_count = stock_count - 1 WHERE id = :id
            ");
            $stmt->execute([':id' => $movie_id]);

            $message = "Rental created successfully!";
        }
    }
}
?>

<h1>New Rental</h1>

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
    <label>Customer:</label><br>
    <select name="customer_id" required>
        <option value="">Select Customer</option>
        <?php foreach ($customers as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Movie:</label><br>
    <select name="movie_id" required>
        <option value="">Select Movie</option>
        <?php foreach ($movies as $m): ?>
            <option value="<?= $m['id'] ?>">
                <?= htmlspecialchars($m['title']) ?> (Stock: <?= $m['stock_count'] ?>)
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Create Rental</button>
</form>

<br>
<a href="rentals.php">Back to Rentals List</a>
<a href="/dashboard.php" class="back-btn">← Back to Dashboard</a>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>