-- Day 18: Database Setup Script
-- Run this script to create the practice database

-- Create database
CREATE DATABASE IF NOT EXISTS day18_practice;
USE day18_practice;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    age INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create products table (for additional practice)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample users
INSERT INTO users (name, email, password, age) VALUES
    ('John Doe', 'john@example.com', 'hashed_password_1', 28),
    ('Jane Smith', 'jane@example.com', 'hashed_password_2', 32),
    ('Bob Wilson', 'bob@example.com', 'hashed_password_3', 25);

-- Insert sample products
INSERT INTO products (name, price, quantity) VALUES
    ('Laptop', 999.99, 10),
    ('Mouse', 29.99, 50),
    ('Keyboard', 79.99, 30);

-- Verify data
SELECT * FROM users;
SELECT * FROM products;
