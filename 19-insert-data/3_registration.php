<?php
/**
 * Day 19: User Registration Form
 * Complete registration with password hashing
 */

require 'db_config.php';

$errors = [];
$success = false;
$username = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($username)) {
        $errors['username'] = "Username is required";
    } elseif (strlen($username) < 3) {
        $errors['username'] = "Username must be at least 3 characters";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters";
    }

    if ($password !== $confirm) {
        $errors['confirm'] = "Passwords do not match";
    }

    // Check if username/email exists
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors['email'] = "Username or email already exists";
        }
    }

    // Register user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);
        $success = true;
        $username = $email = '';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
    <h1>Create Account</h1>

    <?php if ($success): ?>
        <div class="success">✓ Registration successful! You can now login.</div>
    <?php else: ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($username) ?>">
            <?php if (isset($errors['username'])): ?>
                <div class="error-msg"><?= $errors['username'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="error-msg"><?= $errors['email'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Password (min 6 chars)</label>
            <input type="password" name="password">
            <?php if (isset($errors['password'])): ?>
                <div class="error-msg"><?= $errors['password'] ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password">
            <?php if (isset($errors['confirm'])): ?>
                <div class="error-msg"><?= $errors['confirm'] ?></div>
            <?php endif; ?>
        </div>

        <button type="submit">Register</button>
    </form>
    <?php endif; ?>
    </div>
</body>
</html>
