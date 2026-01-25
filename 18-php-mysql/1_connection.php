<?php
/**
 * Day 18: PDO Connection Examples
 *
 * PDO (PHP Data Objects) provides a consistent interface
 * for accessing different databases
 */

echo "=== PDO Connection Examples ===\n\n";

// Database credentials
$host = 'localhost';
$dbname = 'day18_practice';
$username = 'data';
$password = 'data';

// =====================
// METHOD 1: Basic Connection
// =====================

echo "1. Basic PDO Connection:\n";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Connected successfully!\n";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// =====================
// METHOD 2: With Options (Recommended)
// =====================

echo "\n2. Connection with Options (Recommended):\n";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,    // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,          // Fetch as associative array
    PDO::ATTR_EMULATE_PREPARES   => false,                      // Use real prepared statements
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"         // Set charset
];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        $options
    );
    echo "Connected with options!\n";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// =====================
// METHOD 3: DSN String
// =====================

echo "\n3. Using DSN String:\n";

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4;port=3306";

try {
    $pdo3 = new PDO($dsn, $username, $password, $options);
    echo "Connected with DSN!\n";
    $pdo3 = null; // Close connection
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// =====================
// BASIC QUERIES with query()
// =====================

echo "\n4. Simple Query (query method):\n";

$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

echo "Found " . count($users) . " users:\n";
foreach ($users as $user) {
    echo "- {$user['name']} ({$user['email']})\n";
}

// =====================
// FETCH MODES
// =====================

echo "\n5. Different Fetch Modes:\n";

// FETCH_ASSOC (default with our options)
$stmt = $pdo->query("SELECT id, name FROM users LIMIT 1");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo "FETCH_ASSOC: " . json_encode($row) . "\n";

// FETCH_NUM - Numeric array
$stmt = $pdo->query("SELECT id, name FROM users LIMIT 1");
$row = $stmt->fetch(PDO::FETCH_NUM);
echo "FETCH_NUM: " . json_encode($row) . "\n";

// FETCH_BOTH - Both numeric and associative
$stmt = $pdo->query("SELECT id, name FROM users LIMIT 1");
$row = $stmt->fetch(PDO::FETCH_BOTH);
echo "FETCH_BOTH: " . json_encode($row) . "\n";

// FETCH_OBJ - Object
$stmt = $pdo->query("SELECT id, name FROM users LIMIT 1");
$row = $stmt->fetch(PDO::FETCH_OBJ);
echo "FETCH_OBJ: ID={$row->id}, Name={$row->name}\n";

// FETCH_COLUMN - Single column
$stmt = $pdo->query("SELECT name FROM users");
$names = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo "FETCH_COLUMN: " . implode(", ", $names) . "\n";

// =====================
// exec() for non-SELECT queries
// =====================

echo "\n6. Using exec() for INSERT/UPDATE/DELETE:\n";

// exec returns the number of affected rows
$count = $pdo->exec("UPDATE users SET age = age WHERE id = 1");
echo "Affected rows: $count\n";

// =====================
// TRANSACTIONS
// =====================

echo "\n7. Transactions:\n";

try {
    $pdo->beginTransaction();

    $pdo->exec("UPDATE users SET age = age + 1 WHERE id = 1");
    $pdo->exec("UPDATE users SET age = age + 1 WHERE id = 2");

    $pdo->commit();
    echo "Transaction committed!\n";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Transaction rolled back: " . $e->getMessage() . "\n";
}

// Reset ages
$pdo->exec("UPDATE users SET age = age - 1 WHERE id IN (1, 2)");

// =====================
// CONNECTION ATTRIBUTES
// =====================

echo "\n8. Connection Attributes:\n";

echo "Driver: " . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "\n";
echo "Server version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "\n";
echo "Client version: " . $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . "\n";
echo "Connection status: " . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

// =====================
// AVAILABLE PDO DRIVERS
// =====================

echo "\n9. Available PDO Drivers:\n";
$drivers = PDO::getAvailableDrivers();
echo implode(", ", $drivers) . "\n";

// Close connection (optional - happens automatically)
$pdo = null;
echo "\nConnection closed.\n";
