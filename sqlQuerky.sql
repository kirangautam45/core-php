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

-- Table from Practice Task: students
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255),
    age INT
);

-- Optional: Insert sample data for users
INSERT INTO users (name, email) VALUES
    ('John Doe', 'john@example.com'),
    ('Jane Smith', 'jane@example.com'),
    ('Bob Wilson', 'bob@example.com');

-- Optional: Insert sample data for students
INSERT INTO students (name, email, age) VALUES
    ('Alice Johnson', 'alice@email.com', 20),
    ('Charlie Brown', 'charlie@email.com', 22);

-- Verify
SHOW TABLES;
SELECT 'users' AS table_name, COUNT(*) AS row_count FROM users
UNION ALL
SELECT 'students', COUNT(*) FROM students;
