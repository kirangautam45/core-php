<?php
/**
 * DAY 14 - Part 3: Secure Login with Password Verification
 * Time: 15 minutes
 *
 * Learning Goals:
 * - Verify passwords with password_verify()
 * - Handle login securely
 * - Session security (regenerate ID)
 * - Vague error messages for security
 */

session_start();

$usersFile = __DIR__ . '/users.json';

function loadUsers($file) {
    if (!file_exists($file)) {
        return [];
    }
    return json_decode(file_get_contents($file), true) ?? [];
}

function saveUsers($file, $users) {
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
}

$error = '';
$debugInfo = [];

// ============================================
// HANDLE LOGOUT
// ============================================
if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: 03_login.php');
    exit;
}

// ============================================
// PROCESS LOGIN
// ============================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $users = loadUsers($usersFile);
    $foundUser = null;

    // Find user by username (case-insensitive)
    foreach ($users as &$user) {
        if (strtolower($user['username']) === strtolower($username)) {
            $foundUser = &$user;
            break;
        }
    }

    // Debug info (for learning - remove in production!)
    $debugInfo['username_entered'] = $username;
    $debugInfo['user_found'] = $foundUser ? 'Yes' : 'No';

    if ($foundUser) {
        // THE CRITICAL STEP: Verify password using password_verify()
        // This correctly compares the entered password against the hash
        $passwordCorrect = password_verify($password, $foundUser['password']);

        $debugInfo['password_verify_result'] = $passwordCorrect ? 'MATCH' : 'NO MATCH';
        $debugInfo['stored_hash'] = substr($foundUser['password'], 0, 30) . '...';

        if ($passwordCorrect) {
            // Check if password needs rehashing (algorithm update)
            if (password_needs_rehash($foundUser['password'], PASSWORD_DEFAULT)) {
                $foundUser['password'] = password_hash($password, PASSWORD_DEFAULT);
                saveUsers($usersFile, $users);
                $debugInfo['rehashed'] = 'Yes - algorithm updated';
            }

            // SECURITY: Regenerate session ID to prevent session fixation
            session_regenerate_id(true);

            // Store user info in session
            $_SESSION['user'] = [
                'id' => $foundUser['id'],
                'username' => $foundUser['username'],
                'email' => $foundUser['email'],
                'logged_in_at' => date('Y-m-d H:i:s'),
            ];

            // Update last login time
            $foundUser['last_login'] = date('Y-m-d H:i:s');
            saveUsers($usersFile, $users);

            // Redirect to protected page
            header('Location: 03_login.php');
            exit;
        }
    }

    // SECURITY: Use vague error message
    // Don't tell attacker if username exists or not!
    $error = "Invalid username or password";
}

$isLoggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 14: Secure Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 400px;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover { opacity: 0.9; }
        .btn-logout {
            background: #f44336;
        }
        .error {
            background: #ffe6e6;
            color: #d63031;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        .user-info {
            text-align: center;
        }
        .user-avatar {
            font-size: 4em;
            margin-bottom: 10px;
        }
        .user-name {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .session-data {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            text-align: left;
        }
        .debug {
            background: #fff3cd;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 12px;
        }
        .debug h4 { margin: 0 0 10px; color: #856404; }
        code {
            background: rgba(0,0,0,0.1);
            padding: 2px 6px;
            border-radius: 3px;
        }
        a { color: #667eea; }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($isLoggedIn): ?>
            <!-- LOGGED IN VIEW -->
            <div class="card">
                <div class="user-info">
                    <div class="user-avatar">✅</div>
                    <div class="user-name">
                        Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?>!
                    </div>
                    <p>You are successfully logged in.</p>
                </div>

                <div class="session-data">
                    <strong>Session Data:</strong><br>
                    Email: <?= htmlspecialchars($_SESSION['user']['email']) ?><br>
                    Logged in: <?= $_SESSION['user']['logged_in_at'] ?>
                </div>

                <a href="?logout=1">
                    <button class="btn-logout">Log Out</button>
                </a>
            </div>

        <?php else: ?>
            <!-- LOGIN FORM -->
            <div class="card">
                <h1>🔐 Log In</h1>

                <?php if ($error): ?>
                    <div class="error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username"
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                               required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <button type="submit">Log In</button>
                </form>

                <p style="text-align: center; margin-top: 20px;">
                    <a href="02_register.php">Don't have an account? Register</a>
                </p>

                <!-- Debug info for learning -->
                <?php if (!empty($debugInfo)): ?>
                <div class="debug">
                    <h4>🔍 Debug Info (Learning Only)</h4>
                    <p>Username entered: <code><?= htmlspecialchars($debugInfo['username_entered']) ?></code></p>
                    <p>User found in database: <code><?= $debugInfo['user_found'] ?></code></p>
                    <?php if (isset($debugInfo['password_verify_result'])): ?>
                    <p>password_verify() result: <code><?= $debugInfo['password_verify_result'] ?></code></p>
                    <p>Stored hash (truncated): <code><?= htmlspecialchars($debugInfo['stored_hash']) ?></code></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!--
    KEY TAKEAWAYS:

    1. password_verify($entered, $storedHash) - ONLY way to check passwords
    2. NEVER compare passwords with == or ===
    3. Use VAGUE error messages ("Invalid username or password")
       - Don't reveal if username exists
    4. session_regenerate_id(true) after login - prevents session fixation
    5. password_needs_rehash() - update old hashes when algorithm changes
    6. Store minimal user data in session (not password!)
    -->
</body>
</html>
