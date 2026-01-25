-- Day 20: Database Setup Script
-- Run this script to create database with sample data

-- Create database
CREATE DATABASE IF NOT EXISTS day20_practice;
USE day20_practice;

-- Create users table
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

-- Create products table
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

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255)
);

-- Create orders table
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

-- Insert sample users (30 records for pagination)
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

-- Insert sample products (25 records)
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

-- Verify data
SELECT 'Users' as 'Table', COUNT(*) as 'Count' FROM users
UNION ALL
SELECT 'Products', COUNT(*) FROM products
UNION ALL
SELECT 'Categories', COUNT(*) FROM categories
UNION ALL
SELECT 'Orders', COUNT(*) FROM orders;
