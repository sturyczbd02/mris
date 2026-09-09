<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($username && $password && $role) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO users (username, password_hash, role)
            VALUES (:u, :p, :r)
        ");

        $stmt->execute([
            ':u' => $username,
            ':p' => $hash,
            ':r' => $role
        ]);

        $message = "User created successfully!";
    }
}
?>

<h1>Add User</h1>

<?php if ($message): ?>
<p style="color: green;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>Role:</label><br>
    <select name="role" required>
        <option value="admin">Admin</option>
        <option value="manager">Manager</option>
        <option value="employee">Employee</option>
    </select>
    <br><br>

    <button type="submit">Create User</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
