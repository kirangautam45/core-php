-- SQL Lesson Queries & Examples
-- This file accompanies database_setup.sql and covers DML (Data Manipulation) and DQL (Data Querying)

-- ==========================================
-- PART 1: DATA MANIPULATION (DML)
-- Creating, Updating, and Deleting data
-- ==========================================

-- 1. INSERT (Create)
-- Best Practice: Always specify column names
INSERT INTO students (name, email, age) 
VALUES ('David Miller', 'david@test.com', 25);

-- Inserting into specific columns only (nullable columns like email will be NULL)
INSERT INTO students (name, age) 
VALUES ('Evan Wright', 21);

-- 2. UPDATE (Modify)
-- CRITICAL: Always use a WHERE clause, otherwise you update EVERY row!
UPDATE students 
SET age = 21 
WHERE id = 1;

-- Updating multiple columns
UPDATE students 
SET age = 23, email = 'charlie.new@email.com' 
WHERE id = 1;

-- 3. DELETE (Remove)
-- Safety: Referring to ID is the safest way to delete
DELETE FROM students 
WHERE id = 1;


-- ==========================================
-- PART 2: QUERYING DATA (DQL)
-- Retrieving specific information
-- ==========================================

-- 1. Basic Selects
SELECT * FROM users;              -- Get all columns and all rows
SELECT name, email FROM users;    -- Get only specific columns

-- 2. Filtering with WHERE
-- Exact match
SELECT * FROM students WHERE age = 20;

-- Comparisons (> , < , >= , <= , !=)
SELECT * FROM students WHERE age > 21;

-- Logic (AND, OR)
SELECT * FROM students 
WHERE age >= 20 AND age <= 25;

-- Pattern Matching (LIKE)
-- % matches any number of characters
SELECT * FROM users WHERE name LIKE 'J%'; -- Names starting with 'J' (John, Jane)
SELECT * FROM users WHERE email LIKE '%@example.com'; -- Specific domain

-- 3. Sorting & Limits
-- Order By (ASC is default, DESC is reverse)
SELECT * FROM students ORDER BY age DESC;

-- Limit (Good for pagination or just peeking at data)
SELECT * FROM users LIMIT 2;

-- Combining them: "Get the 3 youngest students"
SELECT * FROM students ORDER BY age ASC LIMIT 3;


-- ==========================================
-- PART 3: AGGREGATES
-- Doing math on the data
-- ==========================================

SELECT COUNT(*) AS total_students FROM students;
SELECT AVG(age) AS average_age FROM students;
SELECT MAX(age) AS oldest_age FROM students;


-- ==========================================
-- PART 4: COMPARING STRUCTURE CHANGES (DDL)
-- Concepts for modifying tables
-- ==========================================

-- Add a new column (e.g., for phone numbers)
 ALTER TABLE students ADD phone VARCHAR(15);

-- Modify an existing column
ALTER TABLE students MODIFY name VARCHAR(150);


-- ==========================================
-- PRACTICE ANSWERS
-- Solutions to the challenges
-- ==========================================

-- 1. Find user by email
SELECT * FROM users WHERE email = 'john@example.com';

-- 2. Clean up students without email
DELETE FROM students WHERE email IS NULL;
