<?php
/**
 * DAY 13 - Part 3: Cookies
 * Time: 10 minutes
 *
 * Learning Goals:
 * - Set and read cookies
 * - Cookie expiration times
 * - Use cookies for user preferences
 * - Understand cookie vs session differences
 */

// Handle theme change BEFORE any output
// (Cookies must be set before HTML)
if (isset($_POST['theme'])) {
    $theme = $_POST['theme'];
    // Set cookie for 30 days
    setcookie('theme', $theme, time() + (30 * 24 * 60 * 60), '/');
    // Also update for current request (cookie won't be available until next request)
    $_COOKIE['theme'] = $theme;
}

// Handle cookie deletion
if (isset($_POST['action']) && $_POST['action'] === 'delete_cookies') {
    // Delete by setting expiration in the past
    setcookie('theme', '', time() - 3600, '/');
    setcookie('username', '', time() - 3600, '/');
    unset($_COOKIE['theme'], $_COOKIE['username']);
}

// Handle username cookie
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $username = $_POST['username'];
    // Set cookie for 7 days
    setcookie('username', $username, time() + (7 * 24 * 60 * 60), '/');
    $_COOKIE['username'] = $username;
}

// Get current values
$currentTheme = $_COOKIE['theme'] ?? 'light';
$username = $_COOKIE['username'] ?? '';

// Theme styles
$themes = [
    'light' => ['bg' => '#ffffff', 'text' => '#333333', 'card' => '#f5f5f5'],
    'dark' => ['bg' => '#1a1a2e', 'text' => '#eaeaea', 'card' => '#16213e'],
    'blue' => ['bg' => '#e3f2fd', 'text' => '#0d47a1', 'card' => '#bbdefb'],
];

$theme = $themes[$currentTheme] ?? $themes['light'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 13: Cookies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: 0 auto;
            padding: 40px 20px;
            background: <?= $theme['bg'] ?>;
            color: <?= $theme['text'] ?>;
            transition: all 0.3s ease;
        }
        h1, h2 { color: <?= $theme['text'] ?>; }
        .card {
            background: <?= $theme['card'] ?>;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .card h2 { margin-top: 0; }
        .theme-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .theme-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.2s;
        }
        .theme-btn:hover { transform: scale(1.05); }
        .theme-btn.light { background: #fff; color: #333; border: 1px solid #ccc; }
        .theme-btn.dark { background: #1a1a2e; color: #fff; }
        .theme-btn.blue { background: #2196F3; color: #fff; }
        .theme-btn.active {
            outline: 3px solid #4CAF50;
            outline-offset: 2px;
        }
        input[type="text"] {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 200px;
        }
        button {
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary { background: #4CAF50; color: white; }
        .btn-danger { background: #f44336; color: white; }
        code {
            background: rgba(0,0,0,0.1);
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        pre {
            background: rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
        }
        .cookie-info {
            font-family: monospace;
            font-size: 0.9em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid rgba(128,128,128,0.3);
        }
        th { font-weight: bold; }
    </style>
</head>
<body>
    <h1>🍪 Cookies Demo</h1>

    <?php if ($username): ?>
        <p style="font-size: 1.2em;">Welcome back, <strong><?= htmlspecialchars($username) ?></strong>!</p>
    <?php endif; ?>

    <!-- Theme Selector -->
    <div class="card">
        <h2>Theme Preference</h2>
        <p>Your theme choice is saved in a cookie. Try changing it and refreshing!</p>

        <div class="theme-buttons">
            <?php foreach (['light', 'dark', 'blue'] as $t): ?>
                <form method="POST" style="display: inline;">
                    <input type="hidden" name="theme" value="<?= $t ?>">
                    <button type="submit"
                            class="theme-btn <?= $t ?> <?= $currentTheme === $t ? 'active' : '' ?>">
                        <?= ucfirst($t) ?>
                    </button>
                </form>
            <?php endforeach; ?>
        </div>

        <p class="cookie-info" style="margin-top: 15px;">
            Current theme cookie: <code><?= htmlspecialchars($currentTheme) ?></code>
        </p>
    </div>

    <!-- Remember Username -->
    <div class="card">
        <h2>Remember Me</h2>
        <p>Enter your name and it will be remembered for 7 days.</p>

        <form method="POST">
            <input type="text"
                   name="username"
                   placeholder="Your name"
                   value="<?= htmlspecialchars($username) ?>">
            <button type="submit" class="btn-primary">Save</button>
        </form>
    </div>

    <!-- Current Cookies -->
    <div class="card">
        <h2>Your Cookies</h2>
        <?php if (empty($_COOKIE)): ?>
            <p>No cookies set.</p>
        <?php else: ?>
            <table>
                <tr><th>Name</th><th>Value</th></tr>
                <?php foreach ($_COOKIE as $name => $value): ?>
                    <tr>
                        <td><?= htmlspecialchars($name) ?></td>
                        <td><?= htmlspecialchars($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="action" value="delete_cookies">
            <button type="submit" class="btn-danger">Delete All Cookies</button>
        </form>
    </div>

    <!-- Sessions vs Cookies -->
    <div class="card">
        <h2>Sessions vs Cookies</h2>
        <table>
            <tr>
                <th>Feature</th>
                <th>Sessions</th>
                <th>Cookies</th>
            </tr>
            <tr>
                <td>Storage</td>
                <td>Server</td>
                <td>Browser</td>
            </tr>
            <tr>
                <td>Size Limit</td>
                <td>No limit</td>
                <td>~4KB</td>
            </tr>
            <tr>
                <td>Security</td>
                <td>More secure</td>
                <td>Less secure</td>
            </tr>
            <tr>
                <td>Persistence</td>
                <td>Browser close*</td>
                <td>Configurable</td>
            </tr>
            <tr>
                <td>Best For</td>
                <td>Sensitive data</td>
                <td>Preferences</td>
            </tr>
        </table>
    </div>

    <!--
    KEY TAKEAWAYS:

    1. setcookie() must be called BEFORE any HTML output
    2. Syntax: setcookie('name', 'value', expiration, path)
    3. Expiration: time() + seconds (e.g., time() + 86400 = 1 day)
    4. Delete cookie: set expiration in the past
    5. Cookies available in $_COOKIE on NEXT request
    6. For current request after setting, also update $_COOKIE manually
    7. Use cookies for preferences, sessions for sensitive data
    -->
</body>
</html>
