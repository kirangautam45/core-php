<?php
/**
 * Day 20: Basic Fetch Examples
 *
 * Demonstrates all PDO fetch methods
 */

require_once 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Fetch - Day 20</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Basic Fetch Methods</h1>

        <div class="nav">
            <a href="basic_fetch.php" class="active">Basic Fetch</a>
            <a href="table_display.php">Table Display</a>
            <a href="card_display.php">Card Display</a>
            <a href="search_filter.php">Search & Filter</a>
            <a href="pagination.php">Pagination</a>
        </div>

        <!-- 1. fetch() - Single Row -->
        <h2>1. fetch() - Get Single Row</h2>
        <pre>
$stmt = $pdo->query("SELECT * FROM users LIMIT 1");
$user = $stmt->fetch();
        </pre>
        <?php
        $stmt = $pdo->query("SELECT * FROM users LIMIT 1");
        $user = $stmt->fetch();
        ?>
        <div class="info-box info">
            <strong>Result:</strong> <?= e($user['name']) ?> (<?= e($user['email']) ?>)
        </div>

        <!-- 2. fetchAll() - All Rows -->
        <h2>2. fetchAll() - Get All Rows</h2>
        <pre>
$stmt = $pdo->query("SELECT name, email FROM users LIMIT 5");
$users = $stmt->fetchAll();
        </pre>
        <?php
        $stmt = $pdo->query("SELECT name, email FROM users LIMIT 5");
        $users = $stmt->fetchAll();
        ?>
        <table>
            <tr><th>Name</th><th>Email</th></tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= e($user['name']) ?></td>
                <td><?= e($user['email']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- 3. fetch() in Loop -->
        <h2>3. fetch() in While Loop (Memory Efficient)</h2>
        <pre>
$stmt = $pdo->query("SELECT * FROM products LIMIT 5");
while ($row = $stmt->fetch()) {
    // Process each row
}
        </pre>
        <?php
        $stmt = $pdo->query("SELECT name, price FROM products LIMIT 5");
        ?>
        <ul>
            <?php while ($row = $stmt->fetch()): ?>
            <li><?= e($row['name']) ?> - <?= formatPrice($row['price']) ?></li>
            <?php endwhile; ?>
        </ul>

        <!-- 4. fetchColumn() -->
        <h2>4. fetchColumn() - Single Value</h2>
        <pre>
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$count = $stmt->fetchColumn();
        </pre>
        <?php
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        $count = $stmt->fetchColumn();
        ?>
        <div class="info-box success">
            <strong>Total Users:</strong> <?= $count ?>
        </div>

        <!-- 5. Fetch with Different Modes -->
        <h2>5. Fetch Modes</h2>

        <h3>FETCH_ASSOC (Associative Array)</h3>
        <pre>$row = $stmt->fetch(PDO::FETCH_ASSOC);
// Result: ['name' => 'John', 'email' => 'john@example.com']</pre>
        <?php
        $stmt = $pdo->query("SELECT name, email FROM users LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <pre><?= print_r($row, true) ?></pre>

        <h3>FETCH_NUM (Numeric Array)</h3>
        <pre>$row = $stmt->fetch(PDO::FETCH_NUM);
// Result: [0 => 'John', 1 => 'john@example.com']</pre>
        <?php
        $stmt = $pdo->query("SELECT name, email FROM users LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_NUM);
        ?>
        <pre><?= print_r($row, true) ?></pre>

        <h3>FETCH_OBJ (Object)</h3>
        <pre>$row = $stmt->fetch(PDO::FETCH_OBJ);
// Access: $row->name, $row->email</pre>
        <?php
        $stmt = $pdo->query("SELECT name, email FROM users LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        ?>
        <div class="info-box info">
            Name: <?= e($row->name) ?>, Email: <?= e($row->email) ?>
        </div>

        <h3>FETCH_KEY_PAIR (Key-Value Pairs)</h3>
        <pre>$stmt = $pdo->query("SELECT id, name FROM users");
$users = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
// Result: [1 => 'John', 2 => 'Jane', ...]</pre>
        <?php
        $stmt = $pdo->query("SELECT id, name FROM users LIMIT 5");
        $users = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        ?>
        <pre><?= print_r($users, true) ?></pre>

        <h3>FETCH_COLUMN (All Values from One Column)</h3>
        <pre>$stmt = $pdo->query("SELECT email FROM users");
$emails = $stmt->fetchAll(PDO::FETCH_COLUMN);
// Result: ['john@example.com', 'jane@example.com', ...]</pre>
        <?php
        $stmt = $pdo->query("SELECT email FROM users LIMIT 5");
        $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);
        ?>
        <pre><?= print_r($emails, true) ?></pre>

        <!-- 6. Prepared Statement with Parameters -->
        <h2>6. Prepared Statement with Parameters</h2>
        <pre>
$stmt = $pdo->prepare("SELECT * FROM users WHERE city = ?");
$stmt->execute(['New York']);
$users = $stmt->fetchAll();
        </pre>
        <?php
        $stmt = $pdo->prepare("SELECT name, email, city FROM users WHERE city = ?");
        $stmt->execute(['New York']);
        $users = $stmt->fetchAll();
        ?>
        <table>
            <tr><th>Name</th><th>Email</th><th>City</th></tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= e($user['name']) ?></td>
                <td><?= e($user['email']) ?></td>
                <td><?= e($user['city']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- 7. Named Placeholders -->
        <h2>7. Named Placeholders</h2>
        <pre>
$stmt = $pdo->prepare("SELECT * FROM users WHERE age > :age AND status = :status");
$stmt->execute(['age' => 30, 'status' => 'active']);
        </pre>
        <?php
        $stmt = $pdo->prepare("SELECT name, age, status FROM users WHERE age > :age AND status = :status");
        $stmt->execute(['age' => 30, 'status' => 'active']);
        $users = $stmt->fetchAll();
        ?>
        <table>
            <tr><th>Name</th><th>Age</th><th>Status</th></tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= e($user['name']) ?></td>
                <td><?= e($user['age']) ?></td>
                <td><span class="badge badge-<?= $user['status'] ?>"><?= e($user['status']) ?></span></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <!-- 8. Row Count -->
        <h2>8. Row Count</h2>
        <pre>
$stmt = $pdo->query("SELECT * FROM products WHERE price > 50");
echo "Found " . $stmt->rowCount() . " products";
        </pre>
        <?php
        $stmt = $pdo->query("SELECT * FROM products WHERE price > 50");
        $products = $stmt->fetchAll();
        ?>
        <div class="info-box success">
            Found <strong><?= count($products) ?></strong> products over $50
        </div>

    </div>
</body>
</html>
