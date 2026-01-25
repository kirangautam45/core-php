<?php
/**
 * DAY 14 - Part 2: Secure User Registration
 * Time: 15 minutes
 *
 * Learning Goals:
 * - Validate user input
 * - Hash passwords before storing
 * - Prevent duplicate registrations
 * - Password strength requirements
 */

session_start();

// Simple file-based storage (use database in production)
$usersFile = __DIR__ . '/users.json';

// Load existing users
function loadUsers($file) {
    if (!file_exists($file)) {
        return [];
    }
    return json_decode(file_get_contents($file), true) ?? [];
}

// Save users
function saveUsers($file, $users) {
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
}

$errors = [];
$success = '';

// ============================================
// PROCESS REGISTRATION
// ============================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // VALIDATION

    // 1. Username validation
    if (strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errors[] = "Username can only contain letters, numbers, and underscores";
    }

    // 2. Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }

    // 3. Password validation
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must contain at least one number";
    }

    // 4. Password confirmation
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }

    // 5. Check for duplicate username/email
    if (empty($errors)) {
        $users = loadUsers($usersFile);

        foreach ($users as $user) {
            if (strtolower($user['username']) === strtolower($username)) {
                $errors[] = "Username already taken";
                break;
            }
            if (strtolower($user['email']) === strtolower($email)) {
                $errors[] = "Email already registered";
                break;
            }
        }
    }

    // CREATE USER if no errors
    if (empty($errors)) {
        $users = loadUsers($usersFile);

        // Hash the password - THE MOST IMPORTANT STEP!
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create user record
        $newUser = [
            'id' => count($users) + 1,
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,  // Store HASH, never plain text!
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $users[] = $newUser;
        saveUsers($usersFile, $users);

        $success = "Account created successfully! You can now log in.";

        // Clear form
        $username = $email = '';
    }
}

// Load users for debug display
$users = loadUsers($usersFile);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 14: Secure Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
        }
        h1 { text-align: center; color: #333; }
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
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
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }
        input:focus {
            border-color: #4CAF50;
            outline: none;
        }
        button {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover { background: #45a049; }
        .errors {
            background: #ffe6e6;
            border: 1px solid #ffcccc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .errors ul { margin: 0; padding-left: 20px; color: #d63031; }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
        .requirements {
            background: #fff3cd;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .requirements h4 { margin: 0 0 10px; color: #856404; }
        .requirements ul { margin: 0; padding-left: 20px; color: #856404; }
        .debug {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
        }
        .debug h4 { margin: 0 0 10px; }
        .debug pre {
            background: #263238;
            color: #aed581;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
            font-size: 12px;
        }
        .hash-demo {
            font-family: monospace;
            font-size: 11px;
            word-break: break-all;
            background: #e9e9e9;
            padding: 5px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Create Account</h1>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="requirements">
            <h4>Password Requirements:</h4>
            <ul>
                <li>At least 8 characters</li>
                <li>At least one uppercase letter</li>
                <li>At least one lowercase letter</li>
                <li>At least one number</li>
            </ul>
        </div>

        <div class="card">
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username"
                           value="<?= htmlspecialchars($username ?? '') ?>"
                           required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                           value="<?= htmlspecialchars($email ?? '') ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                </div>

                <button type="submit">Create Account</button>
            </form>

            <p style="text-align: center; margin-top: 20px;">
                <a href="03_login.php">Already have an account? Log in</a>
            </p>
        </div>

        <!-- Debug: Show stored users (for learning only!) -->
        <?php if (!empty($users)): ?>
        <div class="debug">
            <h4>📋 Registered Users (Debug View)</h4>
            <p><em>Notice how passwords are stored as hashes, not plain text!</em></p>
            <?php foreach ($users as $user): ?>
                <div style="margin-bottom: 15px; padding: 10px; background: white; border-radius: 4px;">
                    <strong><?= htmlspecialchars($user['username']) ?></strong>
                    (<?= htmlspecialchars($user['email']) ?>)<br>
                    <small>Password hash:</small>
                    <div class="hash-demo"><?= htmlspecialchars($user['password']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!--
    KEY TAKEAWAYS:

    1. Validate ALL user input before storing
    2. Use password_hash() before saving - CRITICAL!
    3. Check for duplicate username/email
    4. Enforce password strength requirements
    5. Never store plain text passwords
    6. The hash is what goes in the database
    -->
</body>
</html>
