<?php
require 'Database.php';

$error = "";
$success = "";
$token = $_GET['token'] ?? null;
$email = null;

if ($token) {
    // Step 1: Look up the token from password_resets table
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $resetRequest = $stmt->fetch();

    if (!$resetRequest) {
        $error = "This password reset link is invalid or has expired.";
    } else {
        $email = $resetRequest['email']; // Get the correct user email
    }
} else {
    $error = "Invalid or missing reset token.";
}

// Step 2: When the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && $email) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($newPassword) || empty($confirmPassword)) {
        $error = "All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // ✅ Step 3: Hash the new password and update the users table
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        if ($stmt->execute([$hashedPassword, $email])) {
            // ✅ Step 4: Delete the used token
            $pdo->prepare("DELETE FROM password_resets WHERE email = ?")->execute([$email]);

            $success = "Password reset successfully. <a href='login.php'>Click here to log in.</a>";
        } else {
            $error = "Failed to update password. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Tovi Life</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <h2>Reset Your Password</h2>

    <?php if ($error): ?>
        <p style="color: red; text-align: center;"><?php echo $error; ?></p>
    <?php elseif ($success): ?>
        <p style="color: green; text-align: center;"><?php echo $success; ?></p>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form method="POST" action="">
        <label>New Password</label>
        <input type="password" name="new_password" required>

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Reset Password</button>
    </form>
    <?php endif; ?>

    <div class="links">
        <a href="login.php">Back to Login</a>
    </div>
</div>
</body>
</html>