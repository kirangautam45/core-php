# Student Management System - Database CRUD Project

## Project Overview
This is a beginner-friendly project to learn database creation and CRUD (Create, Read, Update, Delete) operations.


## Student Management System

**Database:** `school_db`

**Table:** `students`

**Columns:**
- `id` (INT, Primary Key, Auto Increment)
- `name` (VARCHAR(100))
- `age` (INT)
- `grade` (VARCHAR(10))
- `email` (VARCHAR(100))

**Tasks for students to complete:**

**CREATE** - Add new student records (at least 5 students)
**READ** - Retrieve and display all students
**UPDATE** - Modify existing student information (like updating a student's grade or email)
**DELETE** - Remove a student record from the database

**Bonus queries they can practice:**
- Find the average age of students
- Count how many students are in each grade
- List students sorted by name alphabetically


## Step 1: Create Database

```sql
CREATE DATABASE school_db;
USE school_db;
```

---

## Step 2: Create Table

```sql
CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    age INT,
    grade VARCHAR(10),
    email VARCHAR(100)
);
```

**Table Structure:**
- `id` - Unique identifier for each student (auto-incremented)
- `name` - Student's full name
- `age` - Student's age
- `grade` - Current grade level (e.g., "10th", "11th")
- `email` - Student's email address

---

## Step 3: CRUD Operations

### CREATE - Insert New Records

Add at least 5 students to the database:

```sql
INSERT INTO students (name, age, grade, email) 
VALUES ('John Doe', 16, '10th', 'john.doe@email.com');

INSERT INTO students (name, age, grade, email) 
VALUES ('Jane Smith', 17, '11th', 'jane.smith@email.com');

INSERT INTO students (name, age, grade, email) 
VALUES ('Mike Johnson', 15, '9th', 'mike.j@email.com');

INSERT INTO students (name, age, grade, email) 
VALUES ('Emily Davis', 16, '10th', 'emily.d@email.com');

INSERT INTO students (name, age, grade, email) 
VALUES ('Sarah Wilson', 18, '12th', 'sarah.w@email.com');
```

**Insert multiple records at once:**
```sql
INSERT INTO students (name, age, grade, email) VALUES
('Alex Brown', 17, '11th', 'alex.b@email.com'),
('Lisa Martinez', 15, '9th', 'lisa.m@email.com');
```

---

### READ - Retrieve Records

**1. Display all students:**
```sql
SELECT * FROM students;
```

**2. Display specific columns:**
```sql
SELECT name, grade FROM students;
```

**3. Find students in a specific grade:**
```sql
SELECT * FROM students WHERE grade = '10th';
```

**4. Find students older than 16:**
```sql
SELECT * FROM students WHERE age > 16;
```

**5. Find a student by name:**
```sql
SELECT * FROM students WHERE name = 'John Doe';
```

**6. Sort students by name (alphabetically):**
```sql
SELECT * FROM students ORDER BY name ASC;
```

**7. Sort students by age (youngest first):**
```sql
SELECT * FROM students ORDER BY age ASC;
```

---

### UPDATE - Modify Existing Records

**1. Update a student's email:**
```sql
UPDATE students 
SET email = 'john.newemail@email.com' 
WHERE id = 1;
```

**2. Update a student's grade:**
```sql
UPDATE students 
SET grade = '11th' 
WHERE name = 'John Doe';
```

**3. Update multiple columns:**
```sql
UPDATE students 
SET age = 17, grade = '11th' 
WHERE id = 3;
```

**⚠️ Important:** Always use WHERE clause to avoid updating all records!

---

### DELETE - Remove Records

**1. Delete a specific student by ID:**
```sql
DELETE FROM students WHERE id = 5;
```

**2. Delete students by condition:**
```sql
DELETE FROM students WHERE age < 15;
```

**⚠️ Warning:** Never run `DELETE FROM students;` without WHERE clause - it will delete ALL records!

---

## Bonus Practice Queries

### 1. Count total number of students:
```sql
SELECT COUNT(*) AS total_students FROM students;
```

### 2. Find average age of students:
```sql
SELECT AVG(age) AS average_age FROM students;
```

### 3. Count students in each grade:
```sql
SELECT grade, COUNT(*) AS student_count 
FROM students 
GROUP BY grade;
```

### 4. Find youngest and oldest students:
```sql
SELECT MIN(age) AS youngest, MAX(age) AS oldest FROM students;
```

### 5. Search for students with specific email domain:
```sql
SELECT * FROM students WHERE email LIKE '%@email.com';
```

### 6. Find students whose name starts with 'J':
```sql
SELECT * FROM students WHERE name LIKE 'J%';
```

SELECT AVG(age) AS average_age 
FROM students;

SELECT grade, COUNT(*) AS student_count 
FROM students 
GROUP BY grade
ORDER BY grade;


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


---

## Practice Tasks

Complete these tasks to test your understanding:

1. ✅ Create the database and table
2. ✅ Insert at least 5 different students
3. ✅ Display all students
4. ✅ Find all students in grade "10th"
5. ✅ Update one student's email address
6. ✅ Delete a student record
7. ✅ Count how many students are in the database
8. ✅ Find the average age of all students
9. ✅ List students sorted alphabetically by name
10. ✅ Show only students older than 16

---

## Expected Learning Outcomes

After completing this project, you should be able to:
- Create a database and table with appropriate data types
- Insert single and multiple records
- Retrieve data using SELECT with various conditions
- Update existing records safely
- Delete records with proper WHERE conditions
- Use aggregate functions (COUNT, AVG, MIN, MAX)
- Sort and filter data effectively

---

## Tips for Success

💡 **Always use WHERE clause** with UPDATE and DELETE to avoid affecting all records

💡 **Test your queries** on a small dataset before running on important data

💡 **Use meaningful names** for databases, tables, and columns

💡 **Check your results** after each operation using SELECT

---

## Next Steps

Once you're comfortable with this project, try:
- Adding more tables (teachers, courses)
- Creating relationships between tables
- Adding constraints (UNIQUE, CHECK)
- Learning about JOINs to combine data from multiple tables

Good luck with your database learning journey! 🚀
