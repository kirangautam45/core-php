-- Day 17: Database Setup Script
-- Run this script to create the sample database and table

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
    ('Charlie Brown', 'charlie@example.com', 22),
    ('Diana Prince', 'diana@example.com', 30),
    ('Eve Wilson', 'eve@example.com', 25);

-- Verify data
SELECT * FROM users;
