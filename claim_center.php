<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'Database.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = trim($_POST['description']);
    $amount = floatval($_POST['amount']);

    $stmt = $pdo->prepare("INSERT INTO claims (user_id, description, claim_amount, claim_date, status) VALUES (?, ?, ?, NOW(), 'Pending')");
    if ($stmt->execute([$_SESSION['user_id'], $description, $amount])) {
        $success = "Claim submitted successfully.";
    } else {
        $error = "Failed to submit claim.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claims Center</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <h2>Claims Center</h2>
    <?php if ($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>
    <?php if ($success): ?><p style="color:green;"><?php echo $success; ?></p><?php endif; ?>

    <form method="POST">
        <label for="description">Claim Description</label>
        <textarea name="description" required></textarea>

        <label for="amount">Claim Amount ($)</label>
        <input type="number" name="amount" step="0.01" required>

        <button type="submit">Submit Claim</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>