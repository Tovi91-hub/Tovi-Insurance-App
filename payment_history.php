<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'Database.php';

$stmt = $pdo->prepare("SELECT * FROM payments WHERE user_id = ? ORDER BY payment_date DESC");
$stmt->execute([$_SESSION['user_id']]);
$payments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History | Tovi Life</title>
    <link rel="stylesheet" href="payment-style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>💳 Payment History</h2>

    <?php if (count($payments) > 0): ?>
        <div class="table-wrapper"> <!-- NEW WRAPPER -->
        <table class="payment-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Method</th>
                <th>Reference</th>
                <th>City</th>
                <th>State</th>
                <th>ZIP</th>
                <th>Receipt</th> <!-- ✅ NEW COLUMN -->
            </tr>
        </thead>
            <tbody>
                <?php foreach ($payments as $index => $payment): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($payment['payment_date']) ?></td>
                        <td>$<?= number_format($payment['amount'], 2) ?></td>
                        <td><?= htmlspecialchars($payment['status']) ?></td>
                        <td><?= htmlspecialchars($payment['method']) ?></td>
                        <td>
                            <?= $payment['paypal_email']
                                ?? ($payment['card_last4'] ? '**** **** **** ' . $payment['card_last4'] : null)
                                ?? ($payment['account_number_last4'] ? 'Acct ****' . $payment['account_number_last4'] : '-') ?>
                        </td>
                        <td><?= htmlspecialchars($payment['city']) ?></td>
                        <td><?= htmlspecialchars($payment['state']) ?></td>
                        <td><?= htmlspecialchars($payment['zip_code']) ?></td>
                                <!-- ✅ NEW RECEIPT DOWNLOAD BUTTON -->
                        <td>
                            <a href="generate_receipt.php?payment_id=<?= $payment['payment_id'] ?>" class="btn" target="_blank">
                                🧾 Download
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php else: ?>
        <p>No payments found.</p>
    <?php endif; ?>

    <a class="btn" href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>