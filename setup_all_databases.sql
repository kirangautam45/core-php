-- ============================================================
-- MASTER DATABASE SETUP SCRIPT
-- Creates 'test' user and all practice databases
-- ============================================================
--
-- ╔══════════════════════════════════════════════════════════╗
-- ║                 SETUP INSTRUCTIONS                        ║
-- ╚══════════════════════════════════════════════════════════╝
--
-- ┌──────────────────────────────────────────────────────────┐
-- │                    FOR MAC USERS                          │
-- └──────────────────────────────────────────────────────────┘
--
-- STEP 1: Open Terminal
--         Press Cmd + Space, type "Terminal", press Enter
--
-- STEP 2: Navigate to the project folder
--         cd /path/to/your/days
--
-- STEP 3: Run this script (choose ONE option):
--
--   Option A - If MySQL root has NO password:
--         mysql -u root < setup_all_databases.sql
--
--   Option B - If MySQL root HAS a password:
--         mysql -u root -p < setup_all_databases.sql
--         (Enter your root password when prompted)
--
--   Option C - Using MAMP:
--         /Applications/MAMP/Library/bin/mysql -u root -p < setup_all_databases.sql
--
--   Option D - Using Homebrew MySQL:
--         /opt/homebrew/bin/mysql -u root -p < setup_all_databases.sql
--
-- STEP 4: Verify it worked:
--         mysql -u test -ptest -e "SHOW DATABASES;"
--
--
-- ┌──────────────────────────────────────────────────────────┐
-- │                  FOR WINDOWS USERS                        │
-- └──────────────────────────────────────────────────────────┘
--
-- STEP 1: Open Command Prompt (CMD) as Administrator
--         Press Windows key, type "cmd", right-click, "Run as administrator"
--
-- STEP 2: Navigate to MySQL bin folder (choose based on your setup):
--
--   For XAMPP:
--         cd C:\xampp\mysql\bin
--
--   For WAMP:
--         cd C:\wamp64\bin\mysql\mysql8.0.31\bin
--         (version number may differ)
--
--   For MySQL Installer:
--         cd "C:\Program Files\MySQL\MySQL Server 8.0\bin"
--
-- STEP 3: Run this script (choose ONE option):
--
--   Option A - If MySQL root has NO password:
--         mysql -u root < "C:\path\to\your\days\setup_all_databases.sql"
--
--   Option B - If MySQL root HAS a password:
--         mysql -u root -p < "C:\path\to\your\days\setup_all_databases.sql"
--         (Enter your root password when prompted)
--
--   Option C - Alternative method (copy-paste):
--         1. Open MySQL command line: mysql -u root -p
--         2. Copy all the SQL below and paste into the terminal
--         3. Press Enter
--
-- STEP 4: Verify it worked:
--         mysql -u test -ptest -e "SHOW DATABASES;"
--
--
-- ┌──────────────────────────────────────────────────────────┐
-- │               USING phpMyAdmin (EASIEST)                  │
-- └──────────────────────────────────────────────────────────┘
--
-- STEP 1: Open phpMyAdmin in your browser
--         XAMPP: http://localhost/phpmyadmin
--         MAMP:  http://localhost:8888/phpmyadmin
--         WAMP:  http://localhost/phpmyadmin
--
-- STEP 2: Click on "SQL" tab at the top
--
-- STEP 3: Copy ALL the SQL code below (from "CREATE USER" onwards)
--
-- STEP 4: Paste into the SQL text box
--
-- STEP 5: Click "Go" button to execute
--
-- STEP 6: You should see success messages for each query
--
--
-- ┌──────────────────────────────────────────────────────────┐
-- │                  TROUBLESHOOTING                          │
-- └──────────────────────────────────────────────────────────┘
--
-- ERROR: "Access denied for user 'root'"
--   → Make sure MySQL is running
--   → Check your root password is correct
--   → Try: mysql -u root (without -p) if no password is set
--
-- ERROR: "'mysql' is not recognized" (Windows)
--   → You need to navigate to the MySQL bin folder first
--   → Or add MySQL to your system PATH
--
-- ERROR: "command not found: mysql" (Mac)
--   → Install MySQL: brew install mysql
--   → Or check if MAMP/XAMPP is installed correctly
--
-- ERROR: "User 'test' already exists"
--   → This is OK! The script will continue anyway
--
-- ============================================================
-- SQL SCRIPT STARTS BELOW
-- ============================================================

-- ============================================
-- STEP 1: Create the 'test' user
-- ============================================
CREATE USER IF NOT EXISTS 'test'@'localhost' IDENTIFIED BY 'test';

-- ============================================
-- STEP 2: Create all databases
-- ============================================
CREATE DATABASE IF NOT EXISTS day17_practice;
CREATE DATABASE IF NOT EXISTS day18_practice;
CREATE DATABASE IF NOT EXISTS day19_practice;
CREATE DATABASE IF NOT EXISTS day20_practice;

-- ============================================
-- STEP 3: Grant privileges to 'test' user
-- ============================================
GRANT ALL PRIVILEGES ON day17_practice.* TO 'test'@'localhost';
GRANT ALL PRIVILEGES ON day18_practice.* TO 'test'@'localhost';
GRANT ALL PRIVILEGES ON day19_practice.* TO 'test'@'localhost';
GRANT ALL PRIVILEGES ON day20_practice.* TO 'test'@'localhost';
FLUSH PRIVILEGES;

-- ============================================
-- DAY 17: Users Table
-- ============================================
USE day17_practice;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Clear existing data and insert fresh
TRUNCATE TABLE users;
INSERT INTO users (name, email, age) VALUES
    ('Alice Johnson', 'alice@example.com', 28),
    ('Bob Smith', 'bob@example.com', 35),
    ('Charlie Brown', 'charlie@example.com', 22),
    ('Diana Prince', 'diana@example.com', 30),
    ('Eve Wilson', 'eve@example.com', 25);

-- ============================================
-- DAY 18: Users & Products Tables
-- ============================================
USE day18_practice;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Clear and insert sample data
TRUNCATE TABLE products;
DELETE FROM users;
ALTER TABLE users AUTO_INCREMENT = 1;

INSERT INTO users (name, email, password, age) VALUES
    ('John Doe', 'john@example.com', 'hashed_password_1', 28),
    ('Jane Smith', 'jane@example.com', 'hashed_password_2', 32),
    ('Bob Wilson', 'bob@example.com', 'hashed_password_3', 25);

INSERT INTO products (name, price, quantity) VALUES
    ('Laptop', 999.99, 10),
    ('Mouse', 29.99, 50),
    ('Keyboard', 79.99, 30);

-- ============================================
-- DAY 19: Contacts & Users Tables
-- ============================================
USE day19_practice;

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- DAY 20: Full E-commerce Schema
-- ============================================
USE day20_practice;

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

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255)
);

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

-- Clear and insert day20 sample data
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE orders;
TRUNCATE TABLE products;
TRUNCATE TABLE categories;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- Insert users (30 records for pagination)
INSERT INTO users (name, email, age, city, role, status) VALUES
('John Doe', 'john@example.com', 28, 'New York', 'admin', 'active'),
('Jane Smith', 'jane@example.com', 32, 'Los Angeles', 'user', 'active'),
('Bob Wilson', 'bob@example.com', 25, 'Chicago', 'user', 'active'),
('Alice Brown', 'alice@example.com', 30, 'Houston', 'moderator', 'active'),
('Charlie Davis', 'charlie@example.com', 35, 'Phoenix', 'user', 'inactive'),
('Diana Miller', 'diana@example.com', 27, 'Philadelphia', 'user', 'active'),
('Edward Garcia', 'edward@example.com', 42, 'San Antonio', 'user', 'pending'),
('Fiona Martinez', 'fiona@example.com', 29, 'San Diego', 'user', 'active'),
('George Anderson', 'george@example.com', 38, 'Dallas', 'moderator', 'active'),
('Helen Taylor', 'helen@example.com', 31, 'San Jose', 'user', 'active'),
('Ivan Thomas', 'ivan@example.com', 26, 'Austin', 'user', 'inactive'),
('Julia Jackson', 'julia@example.com', 33, 'Jacksonville', 'user', 'active'),
('Kevin White', 'kevin@example.com', 40, 'Fort Worth', 'user', 'active'),
('Laura Harris', 'laura@example.com', 28, 'Columbus', 'user', 'pending'),
('Michael Clark', 'michael@example.com', 36, 'Charlotte', 'admin', 'active'),
('Nancy Lewis', 'nancy@example.com', 24, 'Seattle', 'user', 'active'),
('Oscar Robinson', 'oscar@example.com', 45, 'Denver', 'user', 'active'),
('Patricia Walker', 'patricia@example.com', 29, 'Boston', 'user', 'inactive'),
('Quinn Hall', 'quinn@example.com', 34, 'Nashville', 'user', 'active'),
('Rachel Allen', 'rachel@example.com', 27, 'Baltimore', 'moderator', 'active'),
('Steve Young', 'steve@example.com', 39, 'Portland', 'user', 'active'),
('Tina King', 'tina@example.com', 31, 'Las Vegas', 'user', 'pending'),
('Ulysses Wright', 'ulysses@example.com', 44, 'Milwaukee', 'user', 'active'),
('Victoria Scott', 'victoria@example.com', 26, 'Albuquerque', 'user', 'active'),
('Walter Green', 'walter@example.com', 37, 'Tucson', 'user', 'inactive'),
('Xena Adams', 'xena@example.com', 30, 'Fresno', 'user', 'active'),
('Yolanda Baker', 'yolanda@example.com', 33, 'Sacramento', 'user', 'active'),
('Zachary Nelson', 'zachary@example.com', 41, 'Mesa', 'user', 'active'),
('Amy Carter', 'amy@example.com', 28, 'Atlanta', 'user', 'active'),
('Brian Mitchell', 'brian@example.com', 35, 'Miami', 'admin', 'active');

-- Insert categories
INSERT INTO categories (name, description) VALUES
('Electronics', 'Electronic devices and accessories'),
('Clothing', 'Apparel and fashion items'),
('Books', 'Books and publications'),
('Home & Garden', 'Home improvement and garden supplies'),
('Sports', 'Sports equipment and accessories');

-- Insert products (25 records)
INSERT INTO products (name, description, price, quantity, category, is_featured) VALUES
('Laptop Pro 15', 'High-performance laptop with 16GB RAM', 1299.99, 25, 'Electronics', TRUE),
('Wireless Mouse', 'Ergonomic wireless mouse with long battery life', 29.99, 150, 'Electronics', FALSE),
('USB-C Hub', '7-in-1 USB-C hub with HDMI and card reader', 49.99, 80, 'Electronics', TRUE),
('Mechanical Keyboard', 'RGB mechanical keyboard with blue switches', 89.99, 60, 'Electronics', FALSE),
('27" Monitor', '4K UHD monitor with HDR support', 399.99, 30, 'Electronics', TRUE),
('Webcam HD', '1080p webcam with built-in microphone', 59.99, 100, 'Electronics', FALSE),
('Cotton T-Shirt', 'Premium cotton t-shirt, available in multiple colors', 24.99, 200, 'Clothing', FALSE),
('Denim Jeans', 'Classic fit denim jeans', 59.99, 120, 'Clothing', TRUE),
('Running Shoes', 'Lightweight running shoes with cushioning', 89.99, 75, 'Clothing', TRUE),
('Winter Jacket', 'Waterproof winter jacket with hood', 149.99, 40, 'Clothing', FALSE),
('JavaScript Guide', 'Complete guide to modern JavaScript', 39.99, 50, 'Books', TRUE),
('Python Cookbook', 'Recipes for mastering Python programming', 44.99, 45, 'Books', FALSE),
('Web Design Basics', 'Introduction to web design principles', 29.99, 60, 'Books', FALSE),
('Database Systems', 'Comprehensive database design book', 54.99, 35, 'Books', TRUE),
('Garden Tools Set', '5-piece garden tools set', 34.99, 80, 'Home & Garden', FALSE),
('LED Desk Lamp', 'Adjustable LED desk lamp with USB port', 39.99, 90, 'Home & Garden', TRUE),
('Plant Pots (Set of 3)', 'Ceramic plant pots in various sizes', 24.99, 110, 'Home & Garden', FALSE),
('Smart Thermostat', 'WiFi-enabled smart thermostat', 129.99, 45, 'Home & Garden', TRUE),
('Yoga Mat', 'Non-slip yoga mat with carrying strap', 29.99, 150, 'Sports', FALSE),
('Dumbbell Set', 'Adjustable dumbbell set (5-25 lbs)', 149.99, 40, 'Sports', TRUE),
('Tennis Racket', 'Professional tennis racket with case', 79.99, 55, 'Sports', FALSE),
('Basketball', 'Official size indoor/outdoor basketball', 24.99, 100, 'Sports', FALSE),
('Fitness Tracker', 'Waterproof fitness tracker with heart rate monitor', 69.99, 85, 'Sports', TRUE),
('Camping Tent', '4-person waterproof camping tent', 119.99, 30, 'Sports', FALSE),
('Bluetooth Speaker', 'Portable Bluetooth speaker with 12hr battery', 44.99, 120, 'Electronics', TRUE);

-- Insert sample orders
INSERT INTO orders (user_id, product_id, quantity, total_price, status) VALUES
(1, 1, 1, 1299.99, 'delivered'),
(2, 7, 2, 49.98, 'delivered'),
(3, 11, 1, 39.99, 'shipped'),
(1, 2, 1, 29.99, 'delivered'),
(4, 5, 1, 399.99, 'processing'),
(5, 19, 2, 59.98, 'pending'),
(2, 8, 1, 59.99, 'delivered'),
(6, 20, 1, 149.99, 'shipped'),
(7, 3, 2, 99.98, 'pending'),
(8, 9, 1, 89.99, 'delivered'),
(3, 16, 1, 39.99, 'processing'),
(9, 12, 1, 44.99, 'delivered'),
(10, 25, 1, 44.99, 'shipped'),
(1, 4, 1, 89.99, 'delivered'),
(4, 23, 1, 69.99, 'pending');

-- ============================================
-- VERIFICATION
-- ============================================
SELECT '=== Setup Complete ===' AS Message;
SELECT 'day17_practice' AS Database_Name, (SELECT COUNT(*) FROM day17_practice.users) AS Users;
SELECT 'day18_practice' AS Database_Name, (SELECT COUNT(*) FROM day18_practice.users) AS Users, (SELECT COUNT(*) FROM day18_practice.products) AS Products;
SELECT 'day19_practice' AS Database_Name, 'Tables created' AS Status;
SELECT 'day20_practice' AS Database_Name, (SELECT COUNT(*) FROM day20_practice.users) AS Users, (SELECT COUNT(*) FROM day20_practice.products) AS Products, (SELECT COUNT(*) FROM day20_practice.orders) AS Orders;

SELECT '' AS '';
SELECT 'User "test" created with password "test"' AS Credentials;
SELECT 'All databases ready!' AS Status;
