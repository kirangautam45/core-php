# Day 18: Connect PHP to MySQL (50 min)

## ⏱️ Lesson Plan

| Time      | Topic                           |
| --------- | ------------------------------- |
| 0-5 min   | MySQLi vs PDO Overview          |
| 5-15 min  | PDO Connection                  |
| 15-30 min | Basic Queries with PDO          |
| 30-45 min | Prepared Statements (Security!) |
| 45-50 min | Practice                        |

---

## 🔌 MySQLi vs PDO (5 min)

| Feature      | MySQLi           | PDO (Recommended)               |
| ------------ | ---------------- | ------------------------------- |
| Databases    | MySQL only       | MySQL, PostgreSQL, SQLite, etc. |
| Style        | Procedural & OOP | OOP only                        |
| Named params | No               | Yes `:name`                     |
| Security     | Good             | Better                          |

**We'll use PDO** - it's more flexible and secure!

---

## 🔗 PDO Connection (10 min)

### Basic Connection

```php
<?php
$host = 'localhost';
$dbname = 'day17_practice';
$username = 'data';
$password = 'data';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Connected!";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
```

### Recommended Connection (with options)

```php
<?php
$pdo = new PDO(
    "mysql:host=localhost;dbname=day17_practice;charset=utf8mb4",
    "root",
    "",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);
```

📁 Save as `db_config.php` and include in other files!

---

## 📖 Basic Queries (15 min)

### SELECT - Fetch All

```php
<?php
require 'db_config.php';

// Get all users
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

// Display
foreach ($users as $user) {
    echo $user['name'] . " - " . $user['email'] . "<br>";
}
```

### SELECT - Fetch One

```php
<?php
$stmt = $pdo->query("SELECT * FROM users LIMIT 1");
$user = $stmt->fetch();

echo "Name: " . $user['name'];
```

### COUNT

```php
<?php
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$count = $stmt->fetchColumn();

echo "Total users: $count";
```

---

## 🔒 Prepared Statements - IMPORTANT! (15 min)

### ❌ NEVER Do This (SQL Injection!)

```php
// DANGEROUS - Hackers can inject SQL!
$name = $_GET['name'];
$sql = "SELECT * FROM users WHERE name = '$name'";
```

### ✅ ALWAYS Use Prepared Statements

```php
// SAFE - Parameters are escaped automatically
$stmt = $pdo->prepare("SELECT * FROM users WHERE name = ?");
$stmt->execute([$_GET['name']]);
$user = $stmt->fetch();
```

### Named Parameters (More Readable)

```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name AND age > :age");
$stmt->execute([
    'name' => 'Alice',
    'age' => 25
]);
$users = $stmt->fetchAll();
```

### INSERT with Prepared Statement

```php
$stmt = $pdo->prepare("INSERT INTO users (name, email, age) VALUES (?, ?, ?)");
$stmt->execute(['John', 'john@example.com', 30]);

// Get the new ID
$newId = $pdo->lastInsertId();
echo "Created user with ID: $newId";
```

### UPDATE with Prepared Statement

```php
$stmt = $pdo->prepare("UPDATE users SET age = ? WHERE id = ?");
$stmt->execute([31, 1]);

echo "Updated rows: " . $stmt->rowCount();
```

### DELETE with Prepared Statement

```php
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([5]);

echo "Deleted rows: " . $stmt->rowCount();
```

---

## ✏️ Practice (5 min)

Create `test_connection.php`:

```php
<?php
// 1. Connect to database
$pdo = new PDO(
    "mysql:host=localhost;dbname=day17_practice;charset=utf8mb4",
    "root", "",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

// 2. Insert a user
$stmt = $pdo->prepare("INSERT INTO users (name, email, age) VALUES (?, ?, ?)");
$stmt->execute(['Test User', 'test@example.com', 25]);
echo "Inserted ID: " . $pdo->lastInsertId() . "<br>";

// 3. Select all users
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>All Users:</h2>";
foreach ($users as $user) {
    echo "{$user['id']}: {$user['name']} ({$user['email']})<br>";
}

// 4. Delete test user
$pdo->prepare("DELETE FROM users WHERE email = ?")->execute(['test@example.com']);
echo "<br>Test user deleted!";
```

---

## 📝 Quick Reference

```php
// Connect
$pdo = new PDO("mysql:host=localhost;dbname=mydb", "root", "");

// Select multiple
$users = $pdo->query("SELECT * FROM users")->fetchAll();

// Select one
$user = $pdo->query("SELECT * FROM users LIMIT 1")->fetch();

// With parameters (SAFE!)
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([1]);
$user = $stmt->fetch();

// Insert
$pdo->prepare("INSERT INTO users (name) VALUES (?)")->execute(['John']);
$id = $pdo->lastInsertId();

// Update
$pdo->prepare("UPDATE users SET name = ? WHERE id = ?")->execute(['Jane', 1]);

// Delete
$pdo->prepare("DELETE FROM users WHERE id = ?")->execute([1]);
```

---

## 📁 Files in This Directory

| File                 | Purpose                        |
| -------------------- | ------------------------------ |
| `database_setup.sql` | Create practice database       |
| `1_connection.php`   | PDO connection examples        |
| `2_prepared.php`     | PDO prepared statements (CRUD) |

---

## ➡️ Next: Day 19 - Insert Form Data into Database
