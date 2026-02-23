-- Day 16: Database Setup Script
-- Run this script to create the database and tables for the Introduction to Databases lesson
--
-- Run from project root:
--   macOS/Linux: mysql -u root -p < 16-database-basics/database_setup.sql
--   Windows:     mysql -u root -p < 16-database-basics\database_setup.sql
--
-- Or copy-paste into phpMyAdmin SQL tab

### Access phpMyAdmin
-- 1. **Start MySQL** (see Setup above)
-- 2. Open: `http://localhost/phpmyadmin` (or use terminal)

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

DESCRIBE users;

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
    ('Charlie Brown', 'charlie@example.com', 22),
    ('Diana Prince', 'diana@example.com', 30),
    ('Eve Wilson', 'eve@example.com', 25);

-- Verify data
SELECT * FROM users;



-- Optional: Insert sample data for users
INSERT INTO users (name, email) VALUES
    ('John Doe', 'john@example.com');
    
    INSERT INTO users (name, email) VALUES
    ('Jane Smith', 'jane@example.com'),
    ('Bob Wilson', 'bob@example.com');
    
    
    SELECT * FROM users;


-- Table from Practice Task: students
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE,
    age INT
);

-- Optional: Insert sample data for students
INSERT INTO students (name, email, age) VALUES
    ('Alice Johnson', 'alice@email.com', 20),
    ('Charlie Brown', 'charlie@email.com', 22);
    
     SELECT name,age FROM students;

-- Verify
SHOW TABLES;

SELECT 'user' AS table_name, COUNT(*) AS row_count FROM users
UNION ALL
SELECT 'student', COUNT(*) FROM students;




-- CRITICAL: Always use a WHERE clause, otherwise you update EVERY row!
UPDATE students 
SET age = 21 , name="kiran Gautam"
WHERE id = 1;


DELETE FROM students 
WHERE id = 1;


-- Exact match
SELECT * FROM students WHERE age = 21;

-- Comparisons (> , < , >= , <= , !=)
SELECT * FROM students WHERE age > 15;
