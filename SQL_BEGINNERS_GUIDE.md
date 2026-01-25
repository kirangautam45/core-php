# SQL for Beginners - A Simple Guide

A step-by-step SQL guide with easy examples.
Works for MySQL, PostgreSQL, SQLite (small differences noted).

---

## 1. What is SQL?

SQL (Structured Query Language) is how we talk to databases.
Think of a database as a collection of spreadsheets (tables).

---

## 2. Basic Database Operations

### Create a Database
```sql
CREATE DATABASE my_store;
```

### Use a Database
```sql
USE my_store;
```

### Delete a Database
```sql
DROP DATABASE my_store;  -- Be careful! This deletes everything!
```

---

## 3. Tables - The Building Blocks

### Create a Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**What each part means:**
| Keyword | Meaning |
|---------|---------|
| `INT` | Whole numbers (1, 2, 3...) |
| `VARCHAR(100)` | Text up to 100 characters |
| `PRIMARY KEY` | Unique identifier for each row |
| `AUTO_INCREMENT` | Automatically adds 1 for each new row |
| `NOT NULL` | This field is required |
| `UNIQUE` | No duplicates allowed |
| `DEFAULT` | Value if none provided |

### View Table Structure
```sql
DESCRIBE users;
-- or
SHOW COLUMNS FROM users;
```

### Delete a Table
```sql
DROP TABLE users;
```

---

## 4. INSERT - Adding Data

### Add One Row
```sql
INSERT INTO users (name, email, age)
VALUES ('John Doe', 'john@email.com', 25);
```

### Add Multiple Rows
```sql
INSERT INTO users (name, email, age) VALUES
    ('Alice', 'alice@email.com', 30),
    ('Bob', 'bob@email.com', 22),
    ('Charlie', 'charlie@email.com', 28);
```

---

## 5. SELECT - Reading Data

### Get All Data
```sql
SELECT * FROM users;
```

### Get Specific Columns
```sql
SELECT name, email FROM users;
```

### Filter with WHERE
```sql
SELECT * FROM users WHERE age > 25;
SELECT * FROM users WHERE name = 'Alice';
SELECT * FROM users WHERE age BETWEEN 20 AND 30;
```

### Common WHERE Operators
| Operator | Example | Meaning |
|----------|---------|---------|
| `=` | `age = 25` | Equals |
| `!=` or `<>` | `age != 25` | Not equals |
| `>` | `age > 25` | Greater than |
| `<` | `age < 25` | Less than |
| `>=` | `age >= 25` | Greater or equal |
| `<=` | `age <= 25` | Less or equal |
| `BETWEEN` | `age BETWEEN 20 AND 30` | In range (inclusive) |
| `IN` | `age IN (20, 25, 30)` | Matches any in list |
| `LIKE` | `name LIKE 'A%'` | Pattern matching |
| `IS NULL` | `email IS NULL` | Is empty/null |

### LIKE Pattern Matching
```sql
SELECT * FROM users WHERE name LIKE 'A%';     -- Starts with A
SELECT * FROM users WHERE name LIKE '%son';   -- Ends with 'son'
SELECT * FROM users WHERE name LIKE '%oh%';   -- Contains 'oh'
SELECT * FROM users WHERE name LIKE 'J_hn';   -- J + any char + hn
```

---

## 6. UPDATE - Changing Data

### Update Specific Rows
```sql
UPDATE users
SET age = 26
WHERE name = 'John Doe';
```

### Update Multiple Columns
```sql
UPDATE users
SET age = 26, email = 'john.new@email.com'
WHERE id = 1;
```

**IMPORTANT:** Always use WHERE with UPDATE, or you'll change ALL rows!

---

## 7. DELETE - Removing Data

### Delete Specific Rows
```sql
DELETE FROM users WHERE id = 1;
DELETE FROM users WHERE age < 18;
```

### Delete All Rows (Keep Table)
```sql
DELETE FROM users;
-- or (faster, resets AUTO_INCREMENT)
TRUNCATE TABLE users;
```

**IMPORTANT:** Always use WHERE with DELETE, or you'll delete EVERYTHING!

---

## 8. Sorting & Limiting

### ORDER BY - Sorting Results
```sql
SELECT * FROM users ORDER BY name;           -- A to Z
SELECT * FROM users ORDER BY name DESC;      -- Z to A
SELECT * FROM users ORDER BY age ASC;        -- Youngest first
SELECT * FROM users ORDER BY age DESC, name; -- Oldest first, then by name
```

### LIMIT - Restricting Results
```sql
SELECT * FROM users LIMIT 5;           -- First 5 rows
SELECT * FROM users LIMIT 5 OFFSET 10; -- Skip 10, get next 5
SELECT * FROM users LIMIT 10, 5;       -- Same as above (MySQL)
```

---

## 9. Aggregate Functions

### COUNT - How Many?
```sql
SELECT COUNT(*) FROM users;                    -- Total rows
SELECT COUNT(*) FROM users WHERE age > 25;     -- Count with condition
```

### SUM, AVG, MIN, MAX
```sql
SELECT SUM(age) FROM users;     -- Total of all ages
SELECT AVG(age) FROM users;     -- Average age
SELECT MIN(age) FROM users;     -- Youngest
SELECT MAX(age) FROM users;     -- Oldest
```

### GROUP BY - Grouping Results
```sql
-- Count users by age
SELECT age, COUNT(*) as count
FROM users
GROUP BY age;

-- Average age by city
SELECT city, AVG(age) as avg_age
FROM users
GROUP BY city;
```

### HAVING - Filter Groups
```sql
-- Cities with more than 5 users
SELECT city, COUNT(*) as user_count
FROM users
GROUP BY city
HAVING COUNT(*) > 5;
```

**Remember:**
- `WHERE` filters rows BEFORE grouping
- `HAVING` filters groups AFTER grouping

---

## 10. JOINs - Combining Tables

Imagine two tables:
```
users                          orders
+----+-------+                 +----+---------+----------+
| id | name  |                 | id | user_id | product  |
+----+-------+                 +----+---------+----------+
| 1  | Alice |                 | 1  | 1       | Laptop   |
| 2  | Bob   |                 | 2  | 1       | Mouse    |
| 3  | Carol |                 | 3  | 2       | Keyboard |
+----+-------+                 +----+---------+----------+
```

### INNER JOIN - Matching Rows Only
```sql
SELECT users.name, orders.product
FROM users
INNER JOIN orders ON users.id = orders.user_id;
```
Result: Alice-Laptop, Alice-Mouse, Bob-Keyboard (Carol excluded - no orders)

### LEFT JOIN - All Left + Matching Right
```sql
SELECT users.name, orders.product
FROM users
LEFT JOIN orders ON users.id = orders.user_id;
```
Result: Includes Carol with NULL product

### Visual Guide to JOINs
```
INNER JOIN: Only matching rows from both tables
LEFT JOIN:  All left table rows + matching right
RIGHT JOIN: All right table rows + matching left
FULL JOIN:  All rows from both tables (MySQL: use UNION)
```

---

## 11. Aliases - Short Names

### Table Aliases
```sql
SELECT u.name, o.product
FROM users AS u
INNER JOIN orders AS o ON u.id = o.user_id;
```

### Column Aliases
```sql
SELECT name AS user_name, age AS user_age FROM users;
SELECT COUNT(*) AS total_users FROM users;
```

---

## 12. Common Patterns

### Check if Data Exists
```sql
SELECT EXISTS(SELECT 1 FROM users WHERE email = 'test@email.com');
```

### Get Unique Values
```sql
SELECT DISTINCT city FROM users;
```

### Combine Conditions
```sql
SELECT * FROM users WHERE age > 20 AND city = 'NYC';
SELECT * FROM users WHERE age < 18 OR age > 65;
SELECT * FROM users WHERE NOT (age > 30);
```

### NULL Handling
```sql
SELECT * FROM users WHERE email IS NULL;
SELECT * FROM users WHERE email IS NOT NULL;
SELECT COALESCE(email, 'no-email') FROM users;  -- Default if NULL
```

---

## 13. Quick Reference

### CRUD Operations
| Operation | SQL Command |
|-----------|-------------|
| **C**reate | `INSERT INTO table (cols) VALUES (vals)` |
| **R**ead | `SELECT cols FROM table WHERE condition` |
| **U**pdate | `UPDATE table SET col = val WHERE condition` |
| **D**elete | `DELETE FROM table WHERE condition` |

### Query Order
```sql
SELECT columns          -- 5. What to show
FROM table              -- 1. Which table
WHERE condition         -- 2. Filter rows
GROUP BY column         -- 3. Group rows
HAVING condition        -- 4. Filter groups
ORDER BY column         -- 6. Sort results
LIMIT number;           -- 7. Limit output
```

---

## 14. Database Differences

| Feature | MySQL | PostgreSQL | SQLite |
|---------|-------|------------|--------|
| Auto ID | `AUTO_INCREMENT` | `SERIAL` | `AUTOINCREMENT` |
| String concat | `CONCAT(a,b)` | `a \|\| b` | `a \|\| b` |
| Case-sensitive LIKE | No (default) | Yes | No |
| Boolean type | TINYINT(1) | BOOLEAN | INTEGER |

---

## 15. Safety Tips

1. **Always backup before DELETE/UPDATE**
2. **Always use WHERE with DELETE/UPDATE**
3. **Test with SELECT first**
   ```sql
   -- First, see what will be affected:
   SELECT * FROM users WHERE age < 18;
   -- Then delete if correct:
   DELETE FROM users WHERE age < 18;
   ```
4. **Use transactions for safety**
   ```sql
   START TRANSACTION;
   DELETE FROM users WHERE id = 5;
   -- Check results, then:
   COMMIT;    -- Save changes
   -- or
   ROLLBACK;  -- Undo changes
   ```

---

Happy querying!
