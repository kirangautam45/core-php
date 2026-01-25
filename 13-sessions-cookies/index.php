<?php
// IMPORTANT: session_start() must be called BEFORE any output!
session_start();

// ========== SESSIONS ==========

// Store data in session
$_SESSION['username'] = 'Kiran';
$_SESSION['cart'] = ['Apple', 'Banana', 'Mango'];

// Read session data
$username = $_SESSION['username'];
$cart = $_SESSION['cart'];

// ========== COOKIES ==========

// Set a cookie (expires in 7 days)
setcookie('theme', 'dark', time() + (7 * 24 * 60 * 60));

// Read cookie (use ?? for default if not set)
$theme = $_COOKIE['theme'] ?? 'light';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Day 13: Sessions & Cookies</title>
</head>
<body>
    <h1>Sessions & Cookies in PHP</h1>

    <h2>Session Data (stored on server)</h2>
    <p>Username: <?= $username ?></p>
    <p>Cart: <?= implode(', ', $cart) ?></p>

    <h2>Cookie Data (stored in browser)</h2>
    <p>Theme: <?= $theme ?></p>

    <hr>
    <h3>Session ID</h3>
    <p><?= session_id() ?></p>

    <hr>
    <p><a href="logout.php">Logout (destroy session)</a></p>
</body>
</html>
