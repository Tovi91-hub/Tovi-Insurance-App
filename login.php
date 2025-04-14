<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tovi Life Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="login-container">
    <h2>Sign In to Tovi Life</h2>
    <form action="authenticate.php" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <button type="submit">Log In</button>
    </form>
    <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
    <p style="color: red; text-align:center;">Incorrect username or password. Please try again.</p>
    <?php endif; ?>
    <div class="links">
        <a href="forgot_password.php">Forgot Password?</a> |
        <a href="register.php">Register</a>
    </div>
</div>
</body>
</html>