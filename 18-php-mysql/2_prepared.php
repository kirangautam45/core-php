<?php
/**
 * Day 18: PDO Prepared Statements
 *
 * Prepared statements are the BEST way to prevent SQL injection
 * PDO supports both named (:name) and positional (?) placeholders
 */

echo "=== PDO Prepared Statements ===\n\n";

// Database connection
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=day18_practice;charset=utf8mb4", "root", "", $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// =====================
// NAMED PLACEHOLDERS (:name)
// =====================

echo "1. Named Placeholders:\n";

$stmt = $pdo->prepare("SELECT * FROM users WHERE age > :age");
$stmt->execute(['age' => 25]);

$users = $stmt->fetchAll();
echo "Users older than 25:\n";
foreach ($users as $user) {
    echo "- {$user['name']}, Age: {$user['age']}\n";
}

// =====================
// POSITIONAL PLACEHOLDERS (?)
// =====================

echo "\n2. Positional Placeholders:\n";

$stmt = $pdo->prepare("SELECT * FROM users WHERE age BETWEEN ? AND ?");
$stmt->execute([20, 35]);

$users = $stmt->fetchAll();
echo "Users aged 20-35:\n";
foreach ($users as $user) {
    echo "- {$user['name']}, Age: {$user['age']}\n";
}

// =====================
// bindValue vs bindParam
// =====================

echo "\n3. bindValue vs bindParam:\n";

// bindValue - binds the value immediately
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$id = 1;
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();
echo "bindValue result: {$user['name']}\n";

// bindParam - binds to variable reference (value evaluated at execute time)
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$id = 1;
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$id = 2;  // Change value before execute
$stmt->execute();
$user = $stmt->fetch();
echo "bindParam result: {$user['name']} (ID was changed to 2 before execute)\n";

// =====================
// INSERT with Named Placeholders
// =====================

echo "\n4. INSERT with Named Placeholders:\n";

$stmt = $pdo->prepare("
    INSERT INTO users (name, email, password, age)
    VALUES (:name, :email, :password, :age)
");

$userData = [
    'name'     => 'PDO User',
    'email'    => 'pdo' . time() . '@example.com',
    'password' => password_hash('secure123', PASSWORD_DEFAULT),
    'age'      => 30
];

$stmt->execute($userData);
$newId = $pdo->lastInsertId();
echo "New user created with ID: $newId\n";

// =====================
// INSERT Multiple Rows
// =====================

echo "\n5. INSERT Multiple Rows:\n";

$stmt = $pdo->prepare("INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)");

$products = [
    ['USB Cable', 9.99, 100],
    ['Mouse Pad', 14.99, 75],
    ['Phone Stand', 24.99, 50]
];

foreach ($products as $product) {
    $stmt->execute($product);
    echo "Inserted: {$product[0]} (ID: " . $pdo->lastInsertId() . ")\n";
}

// =====================
// UPDATE with Prepared Statement
// =====================

echo "\n6. UPDATE with Prepared Statement:\n";

$stmt = $pdo->prepare("UPDATE users SET age = :age, name = :name WHERE id = :id");
$stmt->execute([
    'age'  => 31,
    'name' => 'Updated PDO User',
    'id'   => $newId
]);

echo "Updated " . $stmt->rowCount() . " row(s)\n";

// =====================
// DELETE with Prepared Statement
// =====================

echo "\n7. DELETE with Prepared Statement:\n";

$stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
$stmt->execute(['id' => $newId]);

echo "Deleted " . $stmt->rowCount() . " row(s)\n";

// Clean up products
$pdo->exec("DELETE FROM products WHERE name IN ('USB Cable', 'Mouse Pad', 'Phone Stand')");

// =====================
// LIKE with Prepared Statement
// =====================

echo "\n8. LIKE Query:\n";

// The % must be part of the value, not the SQL
$stmt = $pdo->prepare("SELECT name FROM users WHERE name LIKE :search");
$searchTerm = '%o%';  // Names containing 'o'
$stmt->execute(['search' => $searchTerm]);

echo "Users with 'o' in name:\n";
while ($row = $stmt->fetch()) {
    echo "- {$row['name']}\n";
}

// =====================
// IN Clause (Tricky!)
// =====================

echo "\n9. IN Clause:\n";

$ids = [1, 2, 3];
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT name FROM users WHERE id IN ($placeholders)");
$stmt->execute($ids);

echo "Users with ID 1, 2, or 3:\n";
while ($row = $stmt->fetch()) {
    echo "- {$row['name']}\n";
}

// =====================
// Row Count
// =====================

echo "\n10. Row Count:\n";

$stmt = $pdo->prepare("SELECT * FROM users WHERE age > ?");
$stmt->execute([0]);

echo "Total matching rows: " . $stmt->rowCount() . "\n";

// Close connection
$pdo = null;
echo "\nConnection closed.\n";
