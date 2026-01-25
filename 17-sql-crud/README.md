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
Database: day17_practice
Username: data
Password: data
```

---

## ➡️ Next: Day 18 - Connect PHP to MySQL
