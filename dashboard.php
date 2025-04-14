<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'Database.php';
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tovi Life | Dashboard</title>
    <link rel="stylesheet" href="styleDash.css">
</head>
<body>
<div class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

    <ul class="dashboard-menu">
        <li><a href="view_policies.php">📄 View My Insurance Policies</a></li>
        <li><a href="payment_history.php">💳 Payment History</a></li>
        <li><a href="update_profile.php">🛠️ Update My Profile</a></li>
        <li><a href="claim_center.php">🧾 Submit a Claim</a></li>
        <li><a href="logout.php">🚪 Log Out</a></li>
        <li><a href="payment.php">🚪 Make Payment</a></li>
    </ul>
</div>
</body>
</html>
