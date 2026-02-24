# Day 17: SQL Basics - CRUD Operations (50 min)

## ⏱️ Lesson Plan

| Time | Topic |
|------|-------|
| 0-5 min | Setup Database |
| 5-15 min | SELECT (Read) |
| 15-25 min | INSERT (Create) |
| 25-35 min | UPDATE (Update) |
| 35-45 min | DELETE (Delete) |
| 45-50 min | Practice |

---

## 🛠️ Setup (5 min)

Run in terminal:
```bash
mysql -u root < days/day17/database_setup.sql
```

Or manually:
```sql
CREATE DATABASE IF NOT EXISTS day17_practice;
USE day17_practice;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, age) VALUES
    ('Alice', 'alice@example.com', 28),
    ('Bob', 'bob@example.com', 35),
    ('Charlie', 'charlie@example.com', 22);
```

---

## 📖 SELECT - Read Data (10 min)

### Basic SELECT
```sql
-- All columns
SELECT * FROM users;

-- Specific columns
SELECT name, email FROM users;
```

### With Conditions (WHERE)
```sql
-- Equal to
SELECT * FROM users WHERE age = 28;

-- Greater than
SELECT * FROM users WHERE age > 25;

-- LIKE (pattern matching)
SELECT * FROM users WHERE name LIKE 'A%';    -- Starts with A
SELECT * FROM users WHERE email LIKE '%@gmail%';
```

### Sorting & Limiting
```sql
-- Order by
SELECT * FROM users ORDER BY name ASC;
SELECT * FROM users ORDER BY age DESC;

-- Limit results
SELECT * FROM users LIMIT 5;

-- Combined
SELECT * FROM users ORDER BY age DESC LIMIT 3;
```

### Counting
```sql
SELECT COUNT(*) FROM users;
SELECT COUNT(*) FROM users WHERE age > 25;
```

---

## ➕ INSERT - Create Data (10 min)

### Single Row
```sql
INSERT INTO users (name, email, age)
VALUES ('David', 'david@example.com', 30);
```

### Multiple Rows
```sql
INSERT INTO users (name, email, age) VALUES
    ('Eve', 'eve@example.com', 25),
    ('Frank', 'frank@example.com', 40),
    ('Grace', 'grace@example.com', 33);
```

### Get Last Inserted ID
```sql
SELECT LAST_INSERT_ID();
```

---

## ✏️ UPDATE - Modify Data (10 min)

### Basic Update
```sql
-- Update one column
UPDATE users SET age = 29 WHERE id = 1;

-- Update multiple columns
UPDATE users SET name = 'Alice Smith', age = 30 WHERE id = 1;
```

### Update with Conditions
```sql
-- Update multiple rows
UPDATE users SET age = age + 1 WHERE age < 30;
```

⚠️ **ALWAYS use WHERE!** Without it, ALL rows get updated:
```sql
-- DANGEROUS: Updates everyone!
UPDATE users SET age = 25;
```

---

## 🗑️ DELETE - Remove Data (10 min)

### Basic Delete
```sql
-- Delete specific row
DELETE FROM users WHERE id = 5;

-- Delete with condition
DELETE FROM users WHERE age > 50;
```

⚠️ **ALWAYS use WHERE!** Without it, ALL rows are deleted:
```sql
-- DANGEROUS: Deletes everyone!
DELETE FROM users;
```

### Safe Practice
```sql
-- First, check what will be deleted
SELECT * FROM users WHERE age > 50;

-- Then delete
DELETE FROM users WHERE age > 50;
```

---

## ✏️ Practice Tasks (5 min)

Try these queries:

```sql
-- 1. Select all users older than 25
SELECT * FROM users WHERE age > 25;

-- 2. Insert a new user
INSERT INTO users (name, email, age) VALUES ('Your Name', 'you@example.com', 25);

-- 3. Update your age
UPDATE users SET age = 26 WHERE email = 'you@example.com';

-- 4. Delete your user
DELETE FROM users WHERE email = 'you@example.com';

-- 5. Count users by age group
SELECT age, COUNT(*) as count FROM users GROUP BY age;
```

---

## 📝 CRUD Quick Reference

| Operation | SQL | Example |
|-----------|-----|---------|
| **C**reate | INSERT | `INSERT INTO users (name) VALUES ('John')` |
| **R**ead | SELECT | `SELECT * FROM users WHERE id = 1` |
| **U**pdate | UPDATE | `UPDATE users SET name = 'Jane' WHERE id = 1` |
| **D**elete | DELETE | `DELETE FROM users WHERE id = 1` |

---

## 📁 Files in This Directory

| File | Purpose |
|------|---------|
| `database_setup.sql` | Run this first to create database |
| `db_config.php` | Database connection config |
| `index.php` | Web-based CRUD interface |
| `crud_practice.php` | CLI CRUD examples |

---

## 🚀 Running the Web App

1. Start PHP's built-in server:
   ```bash
   php -S localhost:8000
   ```

2. Open `http://localhost:8000` in your browser

---

## 🔐 Database Credentials

```
Host:     localhost
Database: school_db
Username: data
Password: data
```

---

## ➡️ Next: Day 18 - Connect PHP to MySQL


| Environment | Username | Password |
|---|---|---|
| XAMPP | `root` | *(empty)* |
| MAMP | `root` | `root` |
| Laravel Herd / DBngin | `root` | *(empty)* |
| Custom user | your username | *(empty)* |

---

## 🔷 PDO (PHP Data Objects) Concepts Used

### 1. `new PDO(DSN, username, password)` — Creating a Connection
```php
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
```
- **DSN** (Data Source Name) specifies the driver (`mysql`), host, database name, and charset
- `utf8mb4` supports full Unicode including emojis

---

### 2. `PDO::setAttribute()` — Configuring PDO Behavior
```php
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
```

| Attribute | Value | Meaning |
|---|---|---|
| `ATTR_ERRMODE` | `ERRMODE_EXCEPTION` | Throws `PDOException` on DB errors |
| `ATTR_DEFAULT_FETCH_MODE` | `FETCH_ASSOC` | Returns rows as `['column' => 'value']` arrays |

---

### 3. `$pdo->prepare()` — Prepared Statements
```php
$stmt = $pdo->prepare("INSERT INTO students (...) VALUES (:name, :email, ...)");
```
- Separates SQL structure from data
- **Prevents SQL Injection** — the most important security benefit

---

### 4. `$stmt->execute([...])` — Executing with Named Parameters
```php
$stmt->execute([
    'name'  => $_POST['name'],
    'email' => $_POST['email'],
]);
```
- Named placeholders `:name`, `:email` are bound at execution time
- Data is automatically escaped/sanitized by PDO

---

### 5. `$pdo->query()` — Simple Query (no user input)
```php
$stmt = $pdo->query("SELECT * FROM students ORDER BY id");
```
- Used only when **no user input** is involved (safe from injection by design here)

---

### 6. `fetchAll()` — Fetch All Rows
```php
$students = $stmt->fetchAll();
```
- Returns all matching rows as an array of associative arrays (because `FETCH_ASSOC` is the default)

---

### 7. `fetch()` — Fetch a Single Row
```php
$editStudent = $stmt->fetch();
```
- Returns one row — used when editing a single student by ID

---

### 8. `try / catch (PDOException $e)` — Error Handling
```php
try {
    // DB operations
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
```
- `PDOException` is the specific exception class thrown by PDO
- `$e->getCode()` — gets the **SQLSTATE error code** (e.g., `23000` = duplicate entry / unique constraint violation)
- `$e->getMessage()` — human-readable error message

---

### 9. `require_once` — Including the Config
```php
require_once __DIR__ . '/db_config.php';
```
- Loads the database connection exactly once; fails with a fatal error if not found
- `__DIR__` ensures the path is always relative to the file's location

---

## 🔑 Key Concepts to Explain

| # | Concept | Explanation |
|---|---|---|
| 1 | **What is PDO?** | PHP abstraction layer for databases — works with MySQL, SQLite, PostgreSQL, etc. |
| 2 | **Why PDO over `mysqli_*`?** | Database-agnostic, OOP style, prepared statements built-in |
| 3 | **SQL Injection** | Why `prepare()` + `execute()` is safer than string concatenation |
| 4 | **Named vs Positional Placeholders** | `:name` vs `?` — this project uses named placeholders |
| 5 | **CRUD** | Create (INSERT), Read (SELECT), Update (UPDATE), Delete (DELETE) — all 4 are here |
| 6 | **`FETCH_ASSOC` vs `FETCH_NUM`** | Associative array by column name vs indexed by number |
| 7 | **Error Handling** | `PDOException`, `ERRMODE_EXCEPTION`, error codes like `23000` |
| 8 | **`require_once` for separation of concerns** | Config separated from logic |
| 9 | **HTTP POST handling** | Form submissions use `$_POST['action']` to route to create/update/delete |
| 10 | **`htmlspecialchars()`** | XSS prevention when outputting user data to HTML |

---

## 🛡️ Security Points

| Check | Status | Detail |
|---|---|---|
| SQL Injection | ✅ Safe | `prepare()` + named parameters used throughout |
| XSS | ✅ Safe | `htmlspecialchars()` on all HTML output |
| Duplicate Email | ✅ Handled | Caught using SQLSTATE error code `23000` |
| DB Credentials | ⚠️ Hardcoded | In production, use environment variables (`.env`) |
