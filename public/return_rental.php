<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin', 'manager', 'employee']);
require_once __DIR__ . '/../includes/header.php';

if (!isset($_GET['id'])) {
    die("Rental ID missing.");
}

$id = $_GET['id'];

// Fetch rental
$stmt = $pdo->prepare("SELECT * FROM rentals WHERE id = :id");
$stmt->execute([':id' => $id]);
$rental = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rental) {
    die("Rental not found.");
}

if ($rental['status'] === 'returned') {
    header("Location: rentals.php");
    exit;
}

// Mark returned
$pdo->prepare("
    UPDATE rentals 
    SET return_date = NOW(), status = 'returned'
    WHERE id = :id
")->execute([':id' => $id]);

// Increase stock
$pdo->prepare("
    UPDATE movies 
    SET stock_count = stock_count + 1
    WHERE id = :movie
")->execute([':movie' => $rental['movie_id']]);

header("Location: rentals.php");
exit;

require_once __DIR__ . '/../includes/footer.php';
?>