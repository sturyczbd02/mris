<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin', 'manager', 'employee']);
require_once __DIR__ . '/../includes/header.php';

$message = "";

// Fetch customers
$customers = $pdo->query("SELECT * FROM customers ORDER BY last_name")->fetchAll(PDO::FETCH_ASSOC);

// Fetch movies with stock > 0
$movies = $pdo->query("SELECT * FROM movies WHERE stock_count > 0 ORDER BY title")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $customer_id = $_POST['customer_id'];
    $movie_id = $_POST['movie_id'];

    // Create rental
    $stmt = $pdo->prepare("
        INSERT INTO rentals (customer_id, movie_id, rental_date, status)
        VALUES (:customer, :movie, NOW(), 'out')
    ");

    $stmt->execute([
        ':customer' => $customer_id,
        ':movie'    => $movie_id
    ]);

    // Reduce movie stock
    $pdo->prepare("UPDATE movies SET stock_count = stock_count - 1 WHERE id = :id")
        ->execute([':id' => $movie_id]);

    $message = "Rental created successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>New Rental</title>
</head>
<body>

<h1>Create New Rental</h1>

<?php if ($message): ?>
    <p style="color: green;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">

    <label>Customer:</label><br>
    <select name="customer_id" required>
        <option value="">Select customer</option>
        <?php foreach ($customers as $c): ?>
            <option value="<?= $c['id'] ?>">
                <?= $c['first_name'] . " " . $c['last_name'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Movie:</label><br>
    <select name="movie_id" required>
        <option value="">Select movie</option>
        <?php foreach ($movies as $m): ?>
            <option value="<?= $m['id'] ?>">
                <?= $m['title'] ?> (Stock: <?= $m['stock_count'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <button type="submit">Create Rental</button>
</form>

<br>
<a href="rentals.php">Back to Rentals</a>

</body>
</html>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>