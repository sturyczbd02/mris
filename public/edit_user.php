<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

if (!isset($_GET['id'])) {
    die("User ID missing.");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    if ($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $pdo->prepare("
            UPDATE users SET username=:u, role=:r, password_hash=:p WHERE id=:id
        ")->execute([
            ':u' => $username,
            ':r' => $role,
            ':p' => $hash,
            ':id' => $id
        ]);
    } else {
        $pdo->prepare("
            UPDATE users SET username=:u, role=:r WHERE id=:id
        ")->execute([
            ':u' => $username,
            ':r' => $role,
            ':id' => $id
        ]);
    }

    $message = "User updated successfully!";
}
?>

<h1>Edit User</h1>

<?php if ($message): ?>
<p style="color: green;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
        <option value="manager" <?= $user['role']=='manager'?'selected':'' ?>>Manager</option>
        <option value="employee" <?= $user['role']=='employee'?'selected':'' ?>>Employee</option>
    </select>
    <br><br>

    <label>New Password (optional):</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Save Changes</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
