<?php
session_start();
require __DIR__ . '/db.php';

// Check for "Remember Me" cookie
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $stmt = $pdo->prepare("SELECT username FROM users WHERE remember_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user'] = $user['username'];
        header('Location: profile.php');
        exit;
    } else {
        // Invalid token, clear the cookie
        setcookie('remember_token', '', time() - 3600, '/');
    }
}

// If already logged in, redirect to profile
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

$error = '';
$username = '';
$password = '';

// Get flash message
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    // Check credentials
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $username;

        // Handle "Remember Me"
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $updateStmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
            $updateStmt->execute([$token, $user['id']]);
            
            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 days
        }

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Welcome back, ' . $username . '!'];
        header('Location: profile.php');
        exit;
    } else {
        $error = 'Invalid username or password!';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        form > button[type="submit"].btn-primary {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            opacity: 0.9;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .remember-row {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .remember-row input {
            width: auto;
            margin-right: 8px;
        }
        .remember-row label {
            margin: 0;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Login</h1>

    <?php if ($flash): ?>
        <div class="<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($username) ?>" required>
        <input type="password" name="password" id="password" placeholder="Password" required>

        <div class="remember-row">
            <input type="checkbox" name="remember" id="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>>
            <label for="remember">Remember Me</label>
        </div>
        <button type="submit" name="action" value="login" class="btn-primary">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register</a></p>
</body>
</html>
