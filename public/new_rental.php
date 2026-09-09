<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin','manager','employee']);
require_once __DIR__ . '/../includes/header.php';

$message = "";
$errors = [];

$customers = $pdo->query("SELECT id, first_name, last_name FROM customers ORDER BY last_name")->fetchAll(PDO::FETCH_ASSOC);
$movies = $pdo->query("SELECT id, title, stock FROM movies ORDER BY title")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'] ?? "";
    $movie_id = $_POST['movie_id'] ?? "";

    if (empty($customer_id)) $errors[] = "Customer is required.";
    if (empty($movie_id)) $errors[] = "Movie is required.";

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT stock FROM movies WHERE id = :id");
        $stmt->execute([':id' => $movie_id]);
        $stock = $stmt->fetchColumn();

        if ($stock <= 0) {
            $errors[] = "This movie is out of stock.";
        }
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            INSERT INTO rentals (customer_id, movie_id, rental_date, status)
            VALUES (:cid, :mid, CURDATE(), 'out')
        ");
        $stmt->execute([
            ':cid' => $customer_id,
            ':mid' => $movie_id
        ]);

        $pdo->prepare("UPDATE movies SET stock = stock - 1 WHERE id = :id")
            ->execute([':id' => $movie_id]);

        $message = "Rental created successfully!";
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
            <option value="<?= $c['id'] ?>">
                <?= htmlspecialchars($c['first_name'] . " " . $c['last_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label>Movie:</label><br>
    <select name="movie_id" required>
        <option value="">Select Movie</option>
        <?php foreach ($movies as $m): ?>
            <option value="<?= $m['id'] ?>">
                <?= htmlspecialchars($m['title']) ?> (Stock: <?= $m['stock'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <button type="submit">Create Rental</button>
</form>

<br>
<a href="rentals.php">Back to Rentals</a>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>