<?php
require 'Database.php';

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (empty($email)) {
        $error = "Please enter your email address.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if email exists in database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $resetToken = bin2hex(random_bytes(32));
            $expiresAt = date("Y-m-d H:i:s", strtotime("+30 minutes"));
        
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$email, $resetToken, $expiresAt]);
        
            $resetUrl = "reset_password.php?token=$resetToken";
            $success = "A password reset link has been generated.<br><a href='$resetUrl'>Click here to reset your password</a>";
        } else {
            $error = "Email address not found in our records.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Tovi Life Insurance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <h2>Forgot Password</h2>

    <?php if ($error): ?>
        <p style="color: red; text-align: center;"><?php echo $error; ?></p>
    <?php elseif ($success): ?>
        <p style="color: green; text-align: center;"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" action="forgot_password.php">
        <label for="email">Enter your registered email</label>
        <input type="email" name="email" required>

        <button type="submit">Send Reset Link</button>
    </form>

    <div class="links">
        <a href="login.php">Back to Login</a>
    </div>
</div>
</body>
</html>