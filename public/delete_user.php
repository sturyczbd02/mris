<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);
require_once __DIR__ . '/../includes/db.php';

if (!isset($_GET['id'])) {
    die("User ID missing.");
}

$id = $_GET['id'];

$pdo->prepare("DELETE FROM users WHERE id = :id")
    ->execute([':id' => $id]);

header("Location: users.php");
exit;
?>