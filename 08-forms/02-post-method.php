<?php
/**
 * Day 8: Forms in PHP
 * File 2: $_POST Method
 *
 * Run in browser: http://localhost/02-post-method.php
 */

$message = '';
$messageType = '';
$formData = [
    'username' => '',
    'email' => '',
    'password' => '',
    'remember' => false
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $formData['username'] = trim($_POST['username'] ?? '');
    $formData['email'] = trim($_POST['email'] ?? '');
    $formData['password'] = $_POST['password'] ?? '';
    $formData['remember'] = isset($_POST['remember']);

    // Simple validation
    if (empty($formData['username'])) {
        $message = 'Username is required';
        $messageType = 'error';
    } elseif (empty($formData['email'])) {
        $message = 'Email is required';
        $messageType = 'error';
    } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $message = 'Invalid email format';
        $messageType = 'error';
    } elseif (strlen($formData['password']) < 6) {
        $message = 'Password must be at least 6 characters';
        $messageType = 'error';
    } else {
        // Success - in real app, save to database
        $message = 'Registration successful! Welcome, ' . htmlspecialchars($formData['username']);
        $messageType = 'success';

        // Clear form on success
        $formData = ['username' => '', 'email' => '', 'password' => '', 'remember' => false];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration - POST Method Example</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 500px; margin: 50px auto; padding: 20px; }
        .form-box { background: #f5f5f5; padding: 30px; border-radius: 8px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 12px; font-size: 16px; border: 1px solid #ddd;
            border-radius: 4px; box-sizing: border-box;
        }
        input:focus { border-color: #007bff; outline: none; }
        button { width: 100%; padding: 12px; background: #28a745; color: white;
                border: none; cursor: pointer; font-size: 16px; border-radius: 4px; }
        button:hover { background: #218838; }
        .message { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .info { background: #e7f3ff; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .checkbox-group { display: flex; align-items: center; gap: 8px; }
        .checkbox-group input { width: auto; }
        code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>📝 Registration Form (POST Method)</h1>

    <div class="info">
        <strong>How POST works:</strong><br>
        Data is sent in the request body, NOT visible in URL.<br>
        More secure for sensitive data like passwords.
    </div>

    <?php if ($message): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="form-box">
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"
                       value="<?php echo htmlspecialchars($formData['username']); ?>"
                       placeholder="Enter username">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email"
                       value="<?php echo htmlspecialchars($formData['email']); ?>"
                       placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"
                       placeholder="Enter password (min 6 chars)">
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="remember" name="remember"
                       <?php echo $formData['remember'] ? 'checked' : ''; ?>>
                <label for="remember" style="font-weight: normal;">Remember me</label>
            </div>

            <button type="submit">Register</button>
        </form>
    </div>

    <hr style="margin-top: 40px;">

    <h3>Notice:</h3>
    <p>The URL stays the same after submitting! POST data is not in the URL.</p>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h3>$_POST Data (for debugging):</h3>
        <pre><?php
            // Show POST data but hide password
            $debugData = $_POST;
            if (isset($debugData['password'])) {
                $debugData['password'] = '******** (hidden)';
            }
            print_r($debugData);
        ?></pre>
    <?php endif; ?>

    <h3>Key Points about POST:</h3>
    <ul>
        <li>Data NOT visible in URL</li>
        <li>Cannot be bookmarked</li>
        <li>No practical size limit</li>
        <li>Good for: login, registration, sensitive data</li>
        <li>Access data: <code>$_POST['fieldname']</code></li>
    </ul>
</body>
</html>
