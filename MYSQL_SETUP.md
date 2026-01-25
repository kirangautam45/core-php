# MySQL Setup Guide

## 🔧 Reset MySQL Root Password (Homebrew on macOS)

Your MySQL root password needs to be reset. Follow these steps:

### Step 1: Stop MySQL
```bash
brew services stop mysql
```

### Step 2: Start MySQL in Safe Mode
```bash
mysqld_safe --skip-grant-tables &
```
Wait 3-5 seconds for it to start.

### Step 3: Connect to MySQL
```bash
mysql -u root
```

### Step 4: Reset Password (run inside MySQL)
```sql
FLUSH PRIVILEGES;
ALTER USER 'root'@'localhost' IDENTIFIED BY '';
EXIT;
```
This sets the root password to empty (no password).

### Step 5: Stop Safe Mode & Restart MySQL
```bash
pkill mysqld
brew services start mysql
```

### Step 6: Test Connection
```bash
mysql -u root -e "SELECT 1;"
```

If successful, you should see:
```
+---+
| 1 |
+---+
| 1 |
+---+
```

---

## 📦 Create All Practice Databases

After resetting the password, run these commands to create all databases:

```bash
# Create all databases at once
mysql -u root -e "
CREATE DATABASE IF NOT EXISTS day17_practice;
CREATE DATABASE IF NOT EXISTS day18_practice;
CREATE DATABASE IF NOT EXISTS day19_practice;
CREATE DATABASE IF NOT EXISTS day20_practice;
SHOW DATABASES;
"
```

---

## 🗄️ Day 17: SQL Basics (SELECT, INSERT, UPDATE, DELETE)

### Create Database and Table
```bash
mysql -u root < days/day17/database_setup.sql
```

Or manually:
```sql
-- Create database
CREATE DATABASE IF NOT EXISTS day17_practice;
USE day17_practice;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO users (name, email, age) VALUES
    ('Alice Johnson', 'alice@example.com', 28),
    ('Bob Smith', 'bob@example.com', 35),
    ('Charlie Brown', 'charlie@example.com', 22);
```

### SELECT Queries
```sql
-- Select all
SELECT * FROM users;

-- Select specific columns
SELECT name, email FROM users;

-- Select with condition
SELECT * FROM users WHERE age > 25;

-- Select with ORDER BY
SELECT * FROM users ORDER BY name ASC;

-- Select with LIMIT
SELECT * FROM users LIMIT 5;

-- Select with LIKE (pattern matching)
SELECT * FROM users WHERE name LIKE '%son%';

-- Count rows
SELECT COUNT(*) FROM users;
```

### INSERT Queries
```sql
-- Insert single row
INSERT INTO users (name, email, age) VALUES ('John Doe', 'john@example.com', 30);

-- Insert multiple rows
INSERT INTO users (name, email, age) VALUES
    ('Jane Smith', 'jane@example.com', 25),
    ('Mike Wilson', 'mike@example.com', 40);

-- Get last inserted ID
SELECT LAST_INSERT_ID();
```

### UPDATE Queries
```sql
-- Update single column
UPDATE users SET age = 31 WHERE id = 1;

-- Update multiple columns
UPDATE users SET name = 'John D.', age = 32 WHERE id = 1;

-- Update with condition
UPDATE users SET age = age + 1 WHERE age < 30;
```

### DELETE Queries
```sql
-- Delete by ID
DELETE FROM users WHERE id = 5;

-- Delete with condition
DELETE FROM users WHERE age > 50;

-- ⚠️ DANGER: Delete all (be careful!)
-- DELETE FROM users;
```

---

## 🔌 Day 18: Connect PHP to MySQL (MySQLi / PDO)

### Create Database
```bash
mysql -u root < days/day18/database_setup.sql
```

Or manually:
```sql
CREATE DATABASE IF NOT EXISTS day18_practice;
USE day18_practice;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO users (name, email, password, age) VALUES
    ('John Doe', 'john@example.com', 'hashed_password_1', 28),
    ('Jane Smith', 'jane@example.com', 'hashed_password_2', 32);

INSERT INTO products (name, price, quantity) VALUES
    ('Laptop', 999.99, 10),
    ('Mouse', 29.99, 50);
```

### PHP Connection Examples

**MySQLi Procedural:**
```php
$conn = mysqli_connect("localhost", "root", "", "day18_practice");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
```

**MySQLi OOP:**
```php
$conn = new mysqli("localhost", "root", "", "day18_practice");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
```

**PDO (Recommended):**
```php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=day18_practice", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
```

---

## 📝 Day 19: Insert Data from PHP Form

### Create Database
```bash
mysql -u root < days/day19/database_setup.sql
```

Or manually:
```sql
CREATE DATABASE IF NOT EXISTS day19_practice;
USE day19_practice;

-- Users table for registration
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contacts table for contact form
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT DEFAULT 0,
    category VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### PHP Insert with Prepared Statement (Safe)
```php
// ❌ NEVER DO THIS (SQL Injection vulnerable!)
$sql = "INSERT INTO users (name) VALUES ('$_POST[name]')";

// ✅ ALWAYS use prepared statements
$stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->execute([$_POST['name'], $_POST['email']]);

// Get the inserted ID
$lastId = $pdo->lastInsertId();
```

---

## 📊 Day 20: Fetch & Display Data (SELECT)

### Create Database with Sample Data
```bash
mysql -u root < days/day20/database_setup.sql
```

Or manually:
```sql
CREATE DATABASE IF NOT EXISTS day20_practice;
USE day20_practice;

-- Users table (30 sample records)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    age INT,
    city VARCHAR(50),
    role VARCHAR(20) DEFAULT 'user',
    status ENUM('active', 'inactive', 'pending') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table (25 sample records)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT DEFAULT 0,
    category VARCHAR(50),
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255)
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered') DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample users
INSERT INTO users (name, email, age, city, role, status) VALUES
    ('John Doe', 'john@example.com', 28, 'New York', 'admin', 'active'),
    ('Jane Smith', 'jane@example.com', 32, 'Los Angeles', 'user', 'active'),
    ('Bob Wilson', 'bob@example.com', 25, 'Chicago', 'user', 'active');

-- Insert sample products
INSERT INTO products (name, description, price, quantity, category, is_featured) VALUES
    ('Laptop Pro 15', 'High-performance laptop', 1299.99, 25, 'Electronics', TRUE),
    ('Wireless Mouse', 'Ergonomic wireless mouse', 29.99, 150, 'Electronics', FALSE),
    ('JavaScript Guide', 'Complete JS guide', 39.99, 50, 'Books', TRUE);
```

### PHP Fetch Methods
```php
// fetch() - Single row
$stmt = $pdo->query("SELECT * FROM users LIMIT 1");
$user = $stmt->fetch();

// fetchAll() - All rows
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

// fetchColumn() - Single value
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$count = $stmt->fetchColumn();

// fetch() in loop (memory efficient)
$stmt = $pdo->query("SELECT * FROM users");
while ($row = $stmt->fetch()) {
    echo $row['name'];
}
```

### Search with LIKE
```php
$search = "%laptop%";
$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ?");
$stmt->execute([$search]);
$results = $stmt->fetchAll();
```

### Pagination
```php
$page = 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;

$stmt = $pdo->prepare("SELECT * FROM users LIMIT ? OFFSET ?");
$stmt->execute([$perPage, $offset]);
$users = $stmt->fetchAll();
```

### JOINs
```php
// INNER JOIN - Orders with user and product info
$sql = "
    SELECT o.id, u.name as customer, p.name as product, o.total_price
    FROM orders o
    INNER JOIN users u ON o.user_id = u.id
    INNER JOIN products p ON o.product_id = p.id
";
$orders = $pdo->query($sql)->fetchAll();

// LEFT JOIN - All users with order count
$sql = "
    SELECT u.name, COUNT(o.id) as order_count
    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id
    GROUP BY u.id
";
```

### GROUP BY and Aggregates
```php
// Products by category
$sql = "
    SELECT category,
           COUNT(*) as count,
           AVG(price) as avg_price,
           SUM(quantity) as total_stock
    FROM products
    GROUP BY category
";

// With HAVING (filter groups)
$sql = "
    SELECT category, COUNT(*) as count
    FROM products
    GROUP BY category
    HAVING COUNT(*) >= 3
";
```

---

## 🚀 Quick Setup - Run All SQL Files

```bash
# Make sure MySQL is running
brew services start mysql

# Run all setup files
mysql -u root < days/day17/database_setup.sql
mysql -u root < days/day18/database_setup.sql
mysql -u root < days/day19/database_setup.sql
mysql -u root < days/day20/database_setup.sql

# Verify databases created
mysql -u root -e "SHOW DATABASES;"
```

---

## 📚 Common MySQL Commands Reference

```sql
-- Show all databases
SHOW DATABASES;

-- Use a database
USE database_name;

-- Show all tables
SHOW TABLES;

-- Describe table structure
DESCRIBE table_name;

-- Show create table statement
SHOW CREATE TABLE table_name;

-- Drop database (⚠️ DANGER)
DROP DATABASE database_name;

-- Drop table (⚠️ DANGER)
DROP TABLE table_name;

-- Truncate table (delete all rows, reset auto_increment)
TRUNCATE TABLE table_name;
```

---

## 🔐 Security Best Practices

1. **Always use prepared statements** - Prevents SQL injection
2. **Never store plain text passwords** - Use `password_hash()` and `password_verify()`
3. **Validate and sanitize input** - Check data before inserting
4. **Use CSRF tokens** - Protect forms from cross-site attacks
5. **Limit database user permissions** - Don't use root in production
