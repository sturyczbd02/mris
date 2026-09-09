<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin', 'manager', 'employee']);

// Make sure an ID was passed
if (!isset($_GET['id'])) {
    header("Location: rentals.php");
    exit;
}

$rental_id = (int) $_GET['id'];

// Fetch rental + movie info
$stmt = $pdo->prepare("
    SELECT r.*, m.stock_count 
    FROM rentals r
    JOIN movies m ON r.movie_id = m.id
    WHERE r.id = :id
");
$stmt->execute([':id' => $rental_id]);
$rental = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$rental) {
    die("Rental not found.");
}

// Prevent double returns
if ($rental['status'] === 'returned') {
    header("Location: rentals.php");
    exit;
}

// Update rental record
$stmt = $pdo->prepare("
    UPDATE rentals
    SET return_date = NOW(), status = 'returned'
    WHERE id = :id
");
$stmt->execute([':id' => $rental_id]);

// Increase movie stock
$stmt = $pdo->prepare("
    UPDATE movies
    SET stock_count = stock_count + 1
    WHERE id = :movie_id
");
$stmt->execute([':movie_id' => $rental['movie_id']]);

// Redirect back to rentals list
header("Location: rentals.php");
exit;
?>