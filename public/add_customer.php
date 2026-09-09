<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/permissions.php';
require_role(['admin']);
require_once __DIR__ . '/../includes/header.php';

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO customers (first_name, last_name, email, phone) 
                           VALUES (:first, :last, :email, :phone)");

    $stmt->execute([
        ':first' => $first,
        ':last'  => $last,
        ':email' => $email,
        ':phone' => $phone
    ]);

    $message = "Customer added successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Customer</title>
</head>
<body>

<h1>Add New Customer</h1>

<?php if ($message): ?>
    <p style="color: green;"><?= $message ?></p>
<?php endif; ?>

<form method="POST">
    <label>First Name:</label><br>
    <input type="text" name="first_name" required><br><br>

    <label>Last Name:</label><br>
    <input type="text" name="last_name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Phone:</label><br>
    <input type="text" name="phone"><br><br>

    <button type="submit">Add Customer</button>
</form>

<br>
<a href="customers.php">Back to Customer List</a>

</body>
</html>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>