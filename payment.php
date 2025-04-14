<?php
session_start();
require 'Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$success = $error = "";

// Handle form POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $method = $_POST["method"];
    $amount = floatval($_POST["amount"]);
    $billing_address = trim($_POST["billing_address"]);
    $city = trim($_POST['city']);
    $state = $_POST['state'];
    $zip_code = trim($_POST['zip_code']);

    // Optional method-specific values
    $paypal_email = $card_last4 = $bank_name = $account_last4 = null;

    if ($method === "PayPal") {
        $paypal_email = trim($_POST["paypal_email"]);
        if (!$paypal_email) {
            $error = "PayPal email is required.";
        }
    } elseif ($method === "Credit Card" || $method === "Debit Card") {
        $card_number = preg_replace("/[^0-9]/", "", $_POST["card_number"]);
        $card_last4 = substr($card_number, -4);
        if (!$card_last4 || strlen($card_number) < 13) {
            $error = "Valid card number required.";
        }
    } elseif ($method === "Bank Transfer") {
        $bank_name = trim($_POST["bank_name"]);
        $account_number = preg_replace("/[^0-9]/", "", $_POST["account_number"]);
        $account_last4 = substr($account_number, -4);
        if (!$bank_name || !$account_last4) {
            $error = "Valid bank name and account number required.";
        }
    }

    if (!$error) {
        $stmt = $pdo->prepare("
            INSERT INTO payments 
            (user_id, payment_date, amount, status, method, paypal_email, card_last4, bank_name, account_number_last4, city, state, zip_code) 
            VALUES (?, NOW(), ?, 'Completed', ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $success = $stmt->execute([
            $user_id,
            $amount,
            $method,
            $paypal_email,
            $card_last4,
            $bank_name,
            $account_last4,
            $city,
            $state,
            $zip_code
        ]) ? "Payment successfully recorded." : "Payment failed to record.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment | Tovi Life</title>
    <link rel="stylesheet" href="payment-style.css">
</head>
<body>
<div class="dashboard-container">
    <h2>Make a Payment</h2>

    <?php if ($success): ?>
        <p class="success-message"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="error-message"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="" id="paymentForm">

    <div class="form-group">
        <label>Payment Method</label>
        <select name="method" id="method" required>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
            <option value="PayPal">PayPal</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select>
    </div>

    <!-- CREDIT/DEBIT CARD SECTION -->
    <div id="cardFields" class="dynamic-fields">
        <div class="form-group">
            <label>Cardholder Name</label>
            <input type="text" name="card_name">
        </div>
        <div class="form-group">
            <label>Card Number</label>
            <input type="text" name="card_number" maxlength="19">
        </div>
        <div class="form-group">
            <label>Expiration Date (MM/YY)</label>
            <input type="text" name="expiry" placeholder="MM/YY">
        </div>
        <div class="form-group">
            <label>CVV</label>
            <input type="text" name="cvv" maxlength="4">
        </div>
    </div>

    <!-- PAYPAL SECTION -->
    <div id="paypalFields" class="dynamic-fields" style="display: none;">
        <div class="form-group">
            <label>PayPal Email</label>
            <input type="email" name="paypal_email">
        </div>
    </div>

    <!-- BANK TRANSFER SECTION -->
    <div id="bankFields" class="dynamic-fields" style="display: none;">
        <div class="form-group">
            <label>Bank Name</label>
            <input type="text" name="bank_name">
        </div>
        <div class="form-group">
            <label>Account Number</label>
            <input type="text" name="account_number">
        </div>
        <div class="form-group">
            <label>Routing Number</label>
            <input type="text" name="routing_number">
        </div>
    </div>

    <!-- COMMON FIELDS -->
    <div class="form-group">
        <label>Payment Amount (USD)</label>
        <input type="number" name="amount" step="0.01" min="1" required>
    </div>

    <div class="form-group">
        <label>Billing Address</label>
        <input type="text" name="billing_address">
    </div>

    <div class="form-group">
    <label>City</label>
    <input type="text" name="city" required>
</div>

<div class="form-group">
    <label>State</label>
    <select name="state" required>
        <option value="">-- Select State --</option>
        <option value="AL">Alabama</option>
        <option value="AK">Alaska</option>
        <option value="AZ">Arizona</option>
        <option value="AR">Arkansas</option>
        <option value="CA">California</option>
        <option value="CO">Colorado</option>
        <option value="CT">Connecticut</option>
        <option value="DE">Delaware</option>
        <option value="FL">Florida</option>
        <option value="GA">Georgia</option>
        <option value="HI">Hawaii</option>
        <option value="ID">Idaho</option>
        <option value="IL">Illinois</option>
        <option value="IN">Indiana</option>
        <option value="IA">Iowa</option>
        <option value="KS">Kansas</option>
        <option value="KY">Kentucky</option>
        <option value="LA">Louisiana</option>
        <option value="ME">Maine</option>
        <option value="MD">Maryland</option>
        <option value="MA">Massachusetts</option>
        <option value="MI">Michigan</option>
        <option value="MN">Minnesota</option>
        <option value="MS">Mississippi</option>
        <option value="MO">Missouri</option>
        <option value="MT">Montana</option>
        <option value="NE">Nebraska</option>
        <option value="NV">Nevada</option>
        <option value="NH">New Hampshire</option>
        <option value="NJ">New Jersey</option>
        <option value="NM">New Mexico</option>
        <option value="NY">New York</option>
        <option value="NC">North Carolina</option>
        <option value="ND">North Dakota</option>
        <option value="OH">Ohio</option>
        <option value="OK">Oklahoma</option>
        <option value="OR">Oregon</option>
        <option value="PA">Pennsylvania</option>
        <option value="RI">Rhode Island</option>
        <option value="SC">South Carolina</option>
        <option value="SD">South Dakota</option>
        <option value="TN">Tennessee</option>
        <option value="TX">Texas</option>
        <option value="UT">Utah</option>
        <option value="VT">Vermont</option>
        <option value="VA">Virginia</option>
        <option value="WA">Washington</option>
        <option value="WV">West Virginia</option>
        <option value="WI">Wisconsin</option>
        <option value="WY">Wyoming</option>
        <option value="Other">Other (Non-US)</option>
    </select>
</div>

    <div class="form-group">
        <label>ZIP Code</label>
        <input type="text" name="zip_code">
    </div>

    <button type="submit">Submit Payment</button>
</form>
<script>
document.getElementById("method").addEventListener("change", function () {
    const method = this.value;

    document.getElementById("cardFields").style.display = (method === "Credit Card" || method === "Debit Card") ? "block" : "none";
    document.getElementById("paypalFields").style.display = (method === "PayPal") ? "block" : "none";
    document.getElementById("bankFields").style.display = (method === "Bank Transfer") ? "block" : "none";
});
</script>
    <div class="links">
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</div>
</body>
</html>
