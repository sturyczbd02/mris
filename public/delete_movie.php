<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);

if (!isset($_GET['id'])) {
    die("Movie ID missing.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM movies WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: movies.php");
exit;
?>