<?php
$password = "mySecurePassword123";
$hash = password_hash($password, PASSWORD_DEFAULT);

$hashes = [];
for ($i = 1; $i <= 3; $i++) {
    $hashes[] = password_hash($password, PASSWORD_DEFAULT);
}

$storedHash = password_hash("correctPassword", PASSWORD_DEFAULT);
$attempts = [
    "correctPassword"  => "Should pass",
    "wrongPassword"    => "Should fail",
    "CorrectPassword"  => "Case sensitive",
];

$info = password_get_info($hash);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Hashing Details</title>
    <style>
        body { font-family: Arial; max-width: 700px; margin: 20px auto; padding: 0 20px; }
        .card { background: #f5f5f5; padding: 20px; margin: 15px 0; border-radius: 8px; }
        .hash { background: #263238; color: #aed581; padding: 10px; border-radius: 4px; font-family: monospace; font-size: 12px; word-break: break-all; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .pass { color: green; }
        .fail { color: red; }
        a { color: #667eea; }
    </style>
</head>
<body>
    <h1>Password Hashing Details</h1>

    <div class="card">
        <h2>Why Hash Passwords?</h2>
        <p>If your database gets hacked:</p>
        <ul>
            <li>Plain text: <code>password123</code> - Hacker knows it instantly!</li>
            <li>MD5: <code>482c811...</code> - Cracked in seconds</li>
            <li>Bcrypt: <code>$2y$10$...</code> - Would take years!</li>
        </ul>
    </div>

    <div class="card">
        <h2>Creating Hashes</h2>
        <p><strong>Password:</strong> <?= $password ?></p>
        <div class="hash"><?= $hash ?></div>
        <p><strong>Same password = Different hashes!</strong></p>
        <?php foreach ($hashes as $i => $h): ?>
            <div class="hash">Hash <?= $i + 1 ?>: <?= $h ?></div>
        <?php endforeach; ?>
    </div>

    <div class="card">
        <h2>Verifying Passwords</h2>
        <table>
            <tr><th>Attempt</th><th>Note</th><th>Result</th></tr>
            <?php foreach ($attempts as $attempt => $note): ?>
                <?php $match = password_verify($attempt, $storedHash); ?>
                <tr>
                    <td><code><?= htmlspecialchars($attempt) ?></code></td>
                    <td><?= $note ?></td>
                    <td class="<?= $match ? 'pass' : 'fail' ?>"><?= $match ? 'MATCH' : 'NO MATCH' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="card">
        <h2>Hash Structure</h2>
        <table>
            <tr><th>Part</th><th>Meaning</th></tr>
            <tr><td><code>$2y</code></td><td>Bcrypt algorithm</td></tr>
            <tr><td><code>$10</code></td><td>Cost factor</td></tr>
            <tr><td>Next 22 chars</td><td>Random salt</td></tr>
            <tr><td>Remaining</td><td>The actual hash</td></tr>
        </table>
    </div>

    <p>
        <a href="index.php">Home</a> |
        <a href="02_register.php">Register</a> |
        <a href="03_login.php">Login</a>
    </p>
</body>
</html>
