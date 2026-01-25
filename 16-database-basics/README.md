# Day 16: Introduction to Databases (50 min)

## ⏱️ Lesson Plan

| Time | Topic |
|------|-------|
| 0-10 min | What is a Database? |
| 10-20 min | MySQL Concepts (Tables, Rows, Columns) |
| 20-35 min | Data Types & Primary Keys |
| 35-45 min | phpMyAdmin Demo |
| 45-50 min | Practice Task |

---

## 📚 What is a Database? (10 min)

A database is an organized collection of data stored electronically.

### Why Use Databases?
- Store large amounts of data efficiently
- Retrieve data quickly
- Update and manage data easily
- Multiple users can access simultaneously

### Database vs File Storage

| File (JSON/Text) | Database (MySQL) |
|------------------|------------------|
| Good for small data | Good for large data |
| Slow searching | Fast searching |
| No relationships | Supports relationships |
| Manual backup | Built-in backup tools |

---

## 🗄️ MySQL Concepts (10 min)

### Database Structure
```
Database (e.g., "school")
├── Table: students
├── Table: teachers
└── Table: courses
```

### Tables = Spreadsheets
| id | name | email | age |
|----|------|-------|-----|
| 1 | John | john@email.com | 20 |
| 2 | Jane | jane@email.com | 22 |

- **Rows** = Records (one student)
- **Columns** = Fields (name, email, age)

---

## 📊 Data Types (15 min)

### Most Common Types

| Type | Use For | Example |
|------|---------|---------|
| `INT` | Numbers | `25`, `1000` |
| `VARCHAR(100)` | Short text | `"John Doe"` |
| `TEXT` | Long text | Blog content |
| `DATE` | Dates | `2024-01-15` |
| `DATETIME` | Date + Time | `2024-01-15 10:30:00` |
| `DECIMAL(10,2)` | Money/Prices | `99.99` |
| `BOOLEAN` | True/False | `1` or `0` |

### Primary Key
- **Unique identifier** for each row
- Usually `id` column with AUTO_INCREMENT
- Cannot be NULL or duplicate

```sql
id INT PRIMARY KEY AUTO_INCREMENT
```

---

## 🖥️ phpMyAdmin Demo (10 min)

### Access phpMyAdmin
1. Start MySQL: `brew services start mysql`
2. Open: `http://localhost/phpmyadmin` (or use terminal)

### Create Database (Terminal)
```bash
mysql -u root -e "CREATE DATABASE php_learning;"
```

### Create Table
```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## ✏️ Practice Task (5 min)

Create this structure:

**Database:** `php_learning`

**Table:** `students`
| Column | Type |
|--------|------|
| id | INT (Primary Key, Auto Increment) |
| name | VARCHAR(100) |
| email | VARCHAR(255) |
| age | INT |

```sql
CREATE DATABASE IF NOT EXISTS php_learning;
USE php_learning;

CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255),
    age INT
);
```

---

## 📝 Quick Reference

```sql
-- Create database
CREATE DATABASE database_name;

-- Use database
USE database_name;

-- Create table
CREATE TABLE table_name (
    column_name DATA_TYPE,
    ...
);

-- Show tables
SHOW TABLES;

-- Describe table
DESCRIBE table_name;
```

---

## ➡️ Next: Day 17 - SQL Queries (SELECT, INSERT, UPDATE, DELETE)
