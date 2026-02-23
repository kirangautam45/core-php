-- Day 17: Database Setup Script
-- Run this script to create the sample database and table

-- Create database

CREATE DATABASE IF NOT EXISTS school_db;
USE school_db;

-- Create students table
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    age INT,
    grade VARCHAR(10),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20)
);

-- Insert sample data
INSERT INTO students (name, age, grade, email, phone) 
VALUES ('John Doe', 16, '10th', 'john.doe@email.com', '555-0101'),
('Jane Smith', 17, '11th', 'jane.smith@email.com', '555-0102'),
('Mike Johnson', 15, '9th', 'mike.j@email.com', '555-0103'),
('Emily Davis', 16, '10th', 'emily.d@email.com', '555-0104'),
('Sarah Wilson', 18, '12th', 'sarah.w@email.com', '555-0105'),
('Alex Brown', 17, '11th', 'alex.b@email.com', '555-0106'),
('Lisa Martinez', 15, '9th', 'lisa.m@email.com', '555-0107');

-- Verify data
SELECT * FROM students;