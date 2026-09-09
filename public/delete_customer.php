<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);

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
