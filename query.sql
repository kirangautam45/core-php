### Access phpMyAdmin
-- 1. **Start MySQL**
-- 2. Open: `http://localhost/phpmyadmin`

CREATE DATABASE IF NOT EXISTS school_db;
USE school_db;

CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    age INT,
    grade VARCHAR(10),
    email VARCHAR(100) unique
);

INSERT INTO students (name, age, grade, email) 
VALUES ('John Doe', 16, '10th', 'john.doe@email.com');

INSERT INTO students (name, age, grade, email) 
VALUES ('Jane Smith', 17, '11th', 'jane.smith@email.com');

INSERT INTO students (name, age, grade, email) 
VALUES ('Mike Johnson', 15, '9th', 'mike.j@email.com'),
 ('Emily Davis', 16, '10th', 'emily.d@email.com'),
 ('Sarah Wilson', 18, '12th', 'sarah.w@email.com');


INSERT INTO students (name, age, grade, email) VALUES
('Alex Brown', 17, '11th', 'alex.b@email.com'),
('Lisa Martinez', 15, '9th', 'lisa.m@email.com');


SELECT * FROM students;
SELECT name, grade FROM students;
SELECT * FROM students WHERE grade = '10th';
SELECT * FROM students WHERE age > 16;
SELECT * FROM students ORDER BY name ASC;
SELECT * FROM students ORDER BY age DESC;

UPDATE students 
SET email = 'john.newemail@email.com' 
WHERE id = 1;

UPDATE students 
SET grade = '11th' 
WHERE name = 'John Doe';

UPDATE students 
SET age = 17, grade = '11th' 
WHERE id = 3;

DELETE FROM students WHERE id = 5;

DELETE FROM students WHERE age < 15;

-- ==========================================
-- PART 2: QUERYING DATA (DQL)
-- Retrieving specific information
-- ==========================================

-- 1. Basic Selects
SELECT * FROM students;              -- Get all columns and all rows
SELECT name, email FROM students;    -- Get only specific columns

-- 2. Filtering with WHERE
-- Exact match
SELECT * FROM students WHERE age = 17;

-- Comparisons (> , < , >= , <= , !=)
SELECT * FROM students WHERE age > 15;

-- Logic (AND, OR)
SELECT * FROM students 
WHERE age >= 15 AND age <= 25;

-- Pattern Matching (LIKE)
-- % matches any number of characters
SELECT * FROM students WHERE name LIKE 'j%'; -- Names starting with 'J' (John, Jane)
SELECT * FROM students WHERE email LIKE '%@email.com'; -- Specific domain

-- 3. Sorting & Limits
-- Order By (ASC is default, DESC is reverse)
SELECT * FROM students ORDER BY age DESC;

-- Limit (Good for pagination or just peeking at data)
SELECT * FROM students LIMIT 2;

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



-- 1. Average age
SELECT AVG(age) AS average_age FROM students;

-- 2. Count per grade
SELECT grade, COUNT(*) AS student_count 
FROM students 
GROUP BY grade 
ORDER BY grade;

-- 3. Alphabetical list
SELECT name, age, grade 
FROM students 
ORDER BY name ASC;

 

