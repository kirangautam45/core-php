-- Day 16: Database Setup Script
-- Run this script to create the database and tables for the Introduction to Databases lesson
--
-- Run from project root:
--   macOS/Linux: mysql -u root -p < 16-database-basics/database_setup.sql
--   Windows:     mysql -u root -p < 16-database-basics\database_setup.sql
--
-- Or copy-paste into phpMyAdmin SQL tab

-- Create database
CREATE DATABASE IF NOT EXISTS php_learning;
USE php_learning;

-- Table from phpMyAdmin Demo: users
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Optional: Insert sample data for users
INSERT INTO users (name, email) VALUES
    ('John Doe', 'john@example.com'),
    ('Jane Smith', 'jane@example.com'),
    ('Bob Wilson', 'bob@example.com');


    

-- Table from Practice Task: students
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255),
    age INT
);



-- Optional: Insert sample data for students
INSERT INTO students (name, email, age) VALUES
    ('Alice Johnson', 'alice@email.com', 20),
    ('Charlie Brown', 'charlie@email.com', 22);

-- Verify
SHOW TABLES;
SELECT 'users' AS table_name, COUNT(*) AS row_count FROM users
UNION ALL
SELECT 'students', COUNT(*) FROM students;



-- **Adding a new column to a table:**


ALTER TABLE table_name
ADD column_name data_type;

-- 1. **Add a simple column:**
ALTER TABLE employees
ADD email VARCHAR(100);

-- 2. **Add a column with a default value:**
ALTER TABLE employees
ADD status VARCHAR(20) DEFAULT 'Active';


--3. **Add a column that cannot be NULL:**

ALTER TABLE employees
ADD phone_number VARCHAR(15) NOT NULL;


--4. **Add multiple columns at once:**
ALTER TABLE employees
ADD email VARCHAR(100),
ADD phone VARCHAR(15),
ADD hire_date DATE;


--5. **Add a column with constraints:**

ALTER TABLE employees
ADD employee_code VARCHAR(10) UNIQUE NOT NULL;


--**After adding the column, you can populate it:**

UPDATE employees
SET email = 'default@company.com'
WHERE email IS NULL;


-- **Common data types:**
-- - `VARCHAR(n)` - variable length text
-- - `INT` - integer numbers
-- - `DECIMAL(p,s)` - decimal numbers
-- - `DATE` - date values
-- - `DATETIME` - date and time
-- - `BOOLEAN` - true/false values


-- ==========================================
-- USEFUL SAMPLE SQL SEARCH (SELECT) QUERIES
-- ==========================================

-- 1. Show all users
SELECT * FROM users;

-- 2. Search user by name (exact match)
SELECT * FROM users WHERE name = 'John Doe';

-- 3. Search user by name (partial match)
SELECT * FROM users 
WHERE name LIKE '%John%';

-- 4. Search user by email
SELECT * FROM users 
WHERE email = 'jane@example.com';

-- 5. Search users created today
SELECT * FROM users 
WHERE DATE(created_at) = CURDATE();

-- 6. Search users ordered by newest
SELECT * FROM users 
ORDER BY created_at DESC;

-- 7. Search users with pagination (LIMIT + OFFSET)
-- Page 1
SELECT * FROM users 
LIMIT 2 OFFSET 0;

-- Page 2
SELECT * FROM users 
LIMIT 2 OFFSET 2;

-- 8. Count total users
SELECT COUNT(*) AS total_users FROM users;

-- 9. Search using multiple conditions
SELECT * FROM users 
WHERE name LIKE '%o%' 
AND email LIKE '%example%';

-- 10. Case-insensitive search (default in MySQL)
SELECT * FROM users 
WHERE name LIKE '%john%';

