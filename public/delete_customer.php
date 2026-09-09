<?php
require_once __DIR__ . '/../includes/db.php';

// Ensure an ID was provided
if (!isset($_GET['id'])) {
    die("Customer ID missing.");
}

$id = $_GET['id'];

// Delete the customer
$stmt = $pdo->prepare("DELETE FROM customers WHERE id = :id");
$stmt->execute([':id' => $id]);

// Redirect back to list
header("Location: customers.php");
exit;
?>
