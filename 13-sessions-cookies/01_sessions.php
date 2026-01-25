<?php
/**
 * DAY 13 - Part 1: Session Basics
 * Time: 10 minutes
 *
 * Learning Goals:
 * - Start and use sessions
 * - Store and retrieve session data
 * - Understand session lifecycle
 */

// IMPORTANT: session_start() must be called BEFORE any output!
session_start();

// ============================================
// VISIT COUNTER (Simple Session Demo)
// ============================================

// Initialize counter if not set
if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
    $_SESSION['first_visit'] = date('Y-m-d H:i:s');
}

// Increment on each page load
$_SESSION['visits']++;
$_SESSION['last_visit'] = date('Y-m-d H:i:s');

// ============================================
// STORING DIFFERENT DATA TYPES
// ============================================

// Strings
$_SESSION['username'] = 'demo_user';

// Arrays
$_SESSION['preferences'] = [
    'theme' => 'dark',
    'language' => 'en',
    'notifications' => true
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'set_name':
                $_SESSION['username'] = $_POST['name'] ?? 'Guest';
                break;

            case 'clear_session':
                // Clear all session data
                $_SESSION = [];
                // Destroy the session
                session_destroy();
                // Redirect to start fresh
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;

            case 'remove_visits':
                unset($_SESSION['visits']);
                unset($_SESSION['first_visit']);
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 13: Session Basics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
        }
        h1 { color: #333; }
        .card {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .card h2 {
            margin-top: 0;
            color: #2196F3;
        }
        .stat {
            font-size: 2em;
            font-weight: bold;
            color: #4CAF50;
        }
        .info {
            color: #666;
            font-size: 0.9em;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
        }
        .btn-primary { background: #2196F3; color: white; }
        .btn-danger { background: #f44336; color: white; }
        .btn-warning { background: #ff9800; color: white; }
        .btn-primary:hover { background: #1976D2; }
        .btn-danger:hover { background: #d32f2f; }
        code {
            background: #e9e9e9;
            padding: 2px 6px;
            border-radius: 3px;
        }
        pre {
            background: #263238;
            color: #aed581;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }
        .session-id {
            font-family: monospace;
            font-size: 0.8em;
            color: #999;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <h1>Session Basics</h1>

    <!-- Visit Counter -->
    <div class="card">
        <h2>Visit Counter</h2>
        <div class="stat"><?= $_SESSION['visits'] ?? 0 ?></div>
        <p>times you've loaded this page</p>

        <?php if (isset($_SESSION['first_visit'])): ?>
        <p class="info">
            First visit: <?= $_SESSION['first_visit'] ?><br>
            Last visit: <?= $_SESSION['last_visit'] ?>
        </p>
        <?php endif; ?>

        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="remove_visits">
            <button type="submit" class="btn-warning">Reset Counter</button>
        </form>
    </div>

    <!-- Username Demo -->
    <div class="card">
        <h2>Hello, <?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?>!</h2>

        <form method="POST">
            <input type="hidden" name="action" value="set_name">
            <input type="text" name="name" placeholder="Enter your name">
            <button type="submit" class="btn-primary">Set Name</button>
        </form>
    </div>

    <!-- Session Data Display -->
    <div class="card">
        <h2>Current Session Data</h2>
        <pre><?php print_r($_SESSION); ?></pre>

        <p class="session-id">
            Session ID: <?= session_id() ?>
        </p>

        <form method="POST">
            <input type="hidden" name="action" value="clear_session">
            <button type="submit" class="btn-danger">Destroy Session</button>
        </form>
    </div>


</body>
</html>
