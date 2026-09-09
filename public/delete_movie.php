<?php
require_once __DIR__ . '/../includes/db.php';

if (!isset($_GET['id'])) {
    die("Movie ID missing.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM movies WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: movies.php");
exit;
?>