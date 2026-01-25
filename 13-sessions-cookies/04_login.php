<?php
/**
 * DAY 13 - Part 4: Simple Login System
 * Time: 5 minutes demo
 *
 * Learning Goals:
 * - Combine sessions for authentication
 * - Session security (regenerate ID)
 * - Protected pages
 * - Logout process
 */

session_start();

// Demo users (in real app, use database with hashed passwords)
$users = [
    'admin' => 'password123',
    'user' => 'user123',
    'demo' => 'demo',
];

$error = '';
$page = $_GET['page'] ?? 'login';

// ============================================
// HANDLE LOGIN
// ============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'login') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Check credentials
        if (isset($users[$username]) && $users[$username] === $password) {
            // SECURITY: Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            // Store user info in session
            $_SESSION['user'] = [
                'username' => $username,
                'logged_in_at' => date('Y-m-d H:i:s'),
            ];

            // Redirect to dashboard
            header('Location: ?page=dashboard');
            exit;
        } else {
            $error = 'Invalid username or password';
        }
    }

    if ($_POST['action'] === 'logout') {
        // Clear session data
        $_SESSION = [];

        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"]);
        }

        // Destroy session
        session_destroy();

        header('Location: ?page=login');
        exit;
    }
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);

// Redirect logic
if ($page === 'dashboard' && !$isLoggedIn) {
    header('Location: ?page=login');
    exit;
}
if ($page === 'login' && $isLoggedIn) {
    header('Location: ?page=dashboard');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 13: Login System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input:focus {
            border-color: #667eea;
            outline: none;
        }
        button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-logout {
            background: #f44336;
            color: white;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .error {
            background: #ffe6e6;
            color: #d63031;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        .demo-users {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 0.9em;
        }
        .demo-users h4 { margin: 0 0 10px; }
        .user-info {
            text-align: center;
            margin-bottom: 30px;
        }
        .user-avatar {
            font-size: 4em;
            margin-bottom: 10px;
        }
        .user-name {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
        }
        .session-info {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 0.9em;
        }
        .session-info h4 { margin: 0 0 10px; color: #2e7d32; }
        code {
            background: rgba(0,0,0,0.1);
            padding: 2px 6px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($page === 'login'): ?>
            <!-- LOGIN PAGE -->
            <h1>🔐 Login</h1>

            <?php if ($error): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="action" value="login">

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit" class="btn-login">Log In</button>
            </form>

            <div class="demo-users">
                <h4>Demo Accounts:</h4>
                <ul style="margin: 0; padding-left: 20px;">
                    <li>admin / password123</li>
                    <li>user / user123</li>
                    <li>demo / demo</li>
                </ul>
            </div>

        <?php else: ?>
            <!-- DASHBOARD PAGE (Protected) -->
            <div class="user-info">
                <div class="user-avatar">👤</div>
                <div class="user-name">
                    Hello, <?= htmlspecialchars($_SESSION['user']['username']) ?>!
                </div>
            </div>

            <p style="text-align: center; color: #666;">
                You are logged in. This is a protected page.
            </p>

            <div class="session-info">
                <h4>Session Data:</h4>
                <p>
                    <strong>Username:</strong> <?= htmlspecialchars($_SESSION['user']['username']) ?><br>
                    <strong>Logged in:</strong> <?= $_SESSION['user']['logged_in_at'] ?><br>
                    <strong>Session ID:</strong> <code><?= substr(session_id(), 0, 20) ?>...</code>
                </p>
            </div>

            <form method="POST" style="margin-top: 20px;">
                <input type="hidden" name="action" value="logout">
                <button type="submit" class="btn-logout">Log Out</button>
            </form>
        <?php endif; ?>
    </div>

    <!--
    KEY TAKEAWAYS:

    1. session_regenerate_id(true) - Call after login for security
    2. Store minimal user data in session
    3. Check session on every protected page
    4. Proper logout: clear $_SESSION, delete cookie, destroy session
    5. Never store passwords in sessions!
    6. Redirect after successful login/logout
    -->
</body>
</html>
