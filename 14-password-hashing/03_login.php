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

$error = '';

if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: 03_login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $users = loadUsers($usersFile);
    $foundUser = null;

    foreach ($users as &$user) {
        if (strtolower($user['username']) === strtolower($username)) {
            $foundUser = &$user;
            break;
        }
    }

    if ($foundUser && password_verify($password, $foundUser['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $foundUser['id'],
            'username' => $foundUser['username'],
            'email' => $foundUser['email'],
        ];
        header('Location: 03_login.php');
        exit;
    } else {
        $error = "Invalid username or password";
    }
}

$isLoggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; max-width: 400px; margin: 20px auto; padding: 0 20px; }
        .card { background: #f5f5f5; padding: 20px; margin: 15px 0; border-radius: 8px; }
        .code-box { background: #263238; color: #aed581; padding: 15px; border-radius: 6px; font-family: monospace; }
        input { width: 100%; padding: 10px; margin: 5px 0 15px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .btn-logout { background: #f44336; }
        .error { color: red; }
        .success { color: green; text-align: center; }
        a { color: #667eea; }
    </style>
</head>
<body>
    <?php if ($isLoggedIn): ?>
        <div class="card success">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!</h1>
            <p>Email: <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
            <a href="?logout=1"><button class="btn-logout">Log Out</button></a>
        </div>
    <?php else: ?>
        <h1>Log In</h1>

        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <div class="card">
            <form method="POST">
                <label>Username</label>
                <input type="text" name="username" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit">Log In</button>
            </form>
        </div>


        <p><a href="02_register.php">Don't have an account? Register</a></p>
    <?php endif; ?>

    <p><a href="index.php">Home</a></p>
</body>
</html>
