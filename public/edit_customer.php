<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);
require_once __DIR__ . '/../includes/header.php';

if (!isset($_GET['id'])) die("Customer ID missing.");
$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = :id");
$stmt->execute([':id' => $id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$customer) die("Customer not found.");

$message = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name']);
    $last = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Validation
    if (empty($first)) $errors[] = "First name is required.";
    if (empty($last)) $errors[] = "Last name is required.";
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!empty($phone) && !ctype_digit($phone)) {
        $errors[] = "Phone number must contain only digits.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            UPDATE customers
            SET first_name = :first, last_name = :last, email = :email, phone = :phone
            WHERE id = :id
        ");
        $stmt->execute([
            ':first' => $first,
            ':last' => $last,
            ':email' => $email,
            ':phone' => $phone,
            ':id' => $id
        ]);
        $message = "Customer updated successfully!";
    }
}
?>

<h1>Edit Customer</h1>

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
    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?= htmlspecialchars($customer['first_name']) ?>" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?= htmlspecialchars($customer['last_name']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>"><br><br>

    <button type="submit">Save Changes</button>
</form>

<br>
<a href="customers.php">Back to Customer List</a>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>