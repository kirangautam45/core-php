<?php
session_start();

$username = $_SESSION['user'] ?? null;

// Remove remember token from user data if exists
if ($username) {
    $usersFile = __DIR__ . '/users.json';
    if (file_exists($usersFile)) {
        $users = json_decode(file_get_contents($usersFile), true);
        if (isset($users[$username]['remember_token'])) {
            unset($users[$username]['remember_token']);
            file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
        }
    }
}

// Clear remember_token cookie
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, '/');
}

// Clear session data
$_SESSION = [];

// Destroy session
session_destroy();

// Redirect to login
header('Location: login.php');
exit;
