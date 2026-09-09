<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);
require_once __DIR__ . '/../includes/header.php';

// Make sure an ID was provided
if (!isset($_GET['id'])) {
    die("Customer ID missing.");
}

$id = $_GET['id'];
$message = "";

// Fetch existing customer data
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = :id");
$stmt->execute([':id' => $id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    die("Customer not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $update = $pdo->prepare("
        UPDATE customers 
        SET first_name = :first, last_name = :last, email = :email, phone = :phone
        WHERE id = :id
    ");

    $update->execute([
        ':first' => $first,
        ':last'  => $last,
        ':email' => $email,
        ':phone' => $phone,
        ':id'    => $id
    ]);

    $message = "Customer updated successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
</head>
<body>

<h1>Edit Customer</h1>

<?php if ($message): ?>
    <p style="color: green;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label>First Name:</label><br>
    <input type="text" name="first_name" value="<?= $customer['first_name'] ?>" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" value="<?= $customer['last_name'] ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $customer['email'] ?>"><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone" value="<?= $customer['phone'] ?>"><br><br>

    <button type="submit">Save Changes</button>
</form>

<br>
<a href="customers.php">Back to Customer List</a>

</body>
</html>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>