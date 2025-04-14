<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'Database.php';

$stmt = $pdo->prepare("SELECT * FROM policies WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$policies = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Policies</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <h2>My Insurance Policies</h2>
    <?php if (count($policies) > 0): ?>
        <ul>
        <?php foreach ($policies as $policy): ?>
            <li>
                <strong><?php echo htmlspecialchars($policy['policy_name']); ?></strong><br>
                Type: <?php echo htmlspecialchars($policy['policy_type']); ?> <br>
                Coverage: $<?php echo htmlspecialchars($policy['coverage_amount']); ?><br>
                Status: <?php echo htmlspecialchars($policy['status']); ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No active policies found.</p>
    <?php endif; ?>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>