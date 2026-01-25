<?php
$password = "secret123";
$hash = password_hash($password, PASSWORD_DEFAULT);
$isCorrect = password_verify($password, $hash);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Hashing Basics</title>
    <style>
        body { font-family: Arial; max-width: 600px; margin: 20px auto; padding: 0 20px; }
        .card { background: #f5f5f5; padding: 20px; margin: 15px 0; border-radius: 8px; }
        .code-box { background: #263238; color: #aed581; padding: 15px; border-radius: 6px; font-family: monospace; }
        .pass { color: green; }
        .fail { color: red; }
        input { padding: 10px; margin-right: 10px; }
        button { padding: 10px 20px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        a { color: #667eea; }
    </style>
</head>
<body>
    <h1>Password Hashing Basics</h1>

    <div class="card">
        <h2>Demo</h2>
        <strong>Password:</strong> <?= $password ?><br>
        <strong>Hash:</strong> <?= $hash ?><br>
        <strong>Match:</strong> <span class="<?= $isCorrect ? 'pass' : 'fail' ?>"><?= $isCorrect ? 'Yes' : 'No' ?></span>
    </div>


    <div class="card">
        <h2>Try It</h2>
        <form method="post">
            <input type="text" name="test" placeholder="Enter password" required>
            <button type="submit">Check</button>
        </form>

        <?php if (isset($_POST['test'])): ?>
            <?php $testMatch = password_verify($_POST['test'], $hash); ?>
            <p>
                Testing "<strong><?= htmlspecialchars($_POST['test']) ?></strong>"<br>
                Result: <span class="<?= $testMatch ? 'pass' : 'fail' ?>"><?= $testMatch ? 'MATCH' : 'NO MATCH' ?></span>
            </p>
        <?php endif; ?>
    </div>

    <p>
        <a href="01_hashing.php">Hashing Details</a> |
        <a href="02_register.php">Register</a> |
        <a href="03_login.php">Login</a>
    </p>
</body>
</html>
