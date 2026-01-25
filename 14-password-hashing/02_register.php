<?php
session_start();

$usersFile = __DIR__ . '/users.json';

function loadUsers($file) {
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?? [];
}

function saveUsers($file, $users) {
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (strlen($username) < 3) $errors[] = "Username must be at least 3 characters";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email";
    if (strlen($password) < 8) $errors[] = "Password must be at least 8 characters";
    if ($password !== $confirmPassword) $errors[] = "Passwords do not match";

    if (empty($errors)) {
        $users = loadUsers($usersFile);
        foreach ($users as $user) {
            if (strtolower($user['username']) === strtolower($username)) {
                $errors[] = "Username already taken";
                break;
            }
        }
    }

    if (empty($errors)) {
        $users = loadUsers($usersFile);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $users[] = [
            'id' => count($users) + 1,
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
        ];

        saveUsers($usersFile, $users);
        $success = "Account created! You can now log in.";
        $username = $email = '';
    }
}

$users = loadUsers($usersFile);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 20px auto; padding: 0 20px; }
        .card { background: #f5f5f5; padding: 20px; margin: 15px 0; border-radius: 8px; }
        .code-box { background: #263238; color: #aed581; padding: 15px; border-radius: 6px; font-family: monospace; }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
        a { color: #667eea; }
    </style>
</head>
<body>
    <h1>Create Account</h1>

    <?php if ($errors): ?>
        <p class="error"><?= implode('<br>', $errors) ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <div class="card">
        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Create Account</button>
        </form>
    </div>

    <div class="card">
        <h3>The Code</h3>
        <div class="code-box">
            $hash = password_hash($password, PASSWORD_DEFAULT);<br><br>
            $user = ['password' => $hash];<br>
            saveToDatabase($user);
        </div>
    </div>

    <p><a href="03_login.php">Already have an account? Log in</a></p>
    <p><a href="index.php">Home</a></p>
</body>
</html>
