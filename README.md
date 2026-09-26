# PHP Learning Journey — 45 Days of Core PHP & MySQL

**A free, beginner-friendly PHP course: 20+ hands-on lessons from "Hello World" to secure login systems and MySQL CRUD — no frameworks, just core PHP.**

[![GitHub stars](https://img.shields.io/github/stars/kirangautam45/core-php?style=social)](https://github.com/kirangautam45/core-php/stargazers)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](#contributing)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-PDO-4479A1?logo=mysql&logoColor=white)

> ⭐ **If these lessons help you learn or teach PHP, please star the repo** — it helps other beginners find it.

**Jump to:** [Lessons](#progress-tracker) · [Quick start](#quick-start) · [Guides](#guides) · [Full 45-day plan](php-learning-plan.md) · [Contributing](#contributing)

## Who this is for

- Beginners who know basic HTML and want to learn backend development
- Teachers looking for a ready-made, day-by-day PHP curriculum
- Developers who want to understand **core PHP** before jumping into Laravel

Every lesson folder has its own `README.md` explaining the concept, plus runnable example files.

## Quick start

```bash
git clone https://github.com/kirangautam45/core-php.git
cd core-php/01-hello-world
php -S localhost:8000
```

Open http://localhost:8000 in your browser. For the database lessons (Day 16+), follow [MYSQL_SETUP.md](MYSQL_SETUP.md) first.

## Guides

| Guide | What it covers |
|---|---|
| [php-learning-plan.md](php-learning-plan.md) | The full 45-day plan with daily topics |
| [MYSQL_SETUP.md](MYSQL_SETUP.md) | Installing and configuring MySQL |
| [DATABASE_SETUP.md](DATABASE_SETUP.md) | Creating the databases used in the lessons |
| [SQL_BEGINNERS_GUIDE.md](SQL_BEGINNERS_GUIDE.md) | SQL basics for beginners: databases, tables and CRUD queries |
| [GIT-GUIDE.md](GIT-GUIDE.md) | Everyday Git commands: setup, commits, branches |
| [code-review-template.md](code-review-template.md) | Code review assessment for grading student projects |

## Progress Tracker

### Completed Days

- ✅ [01](01-hello-world) - Hello World
- ✅ [02](02-variables-datatypes) - Variables & Data Types
- ✅ [03](03-operators-conditionals) - Operators & Conditionals
- ✅ [04](04-loops) - Loops
- ✅ [05](05-arrays) - Arrays
- ✅ [06](06-functions) - Functions
- ✅ [07](07-builtin-functions) - Built-in Functions
- ✅ [08](08-forms) - Forms & GET/POST
- ✅ [09](09-form-validation) - Form Validation
- ✅ [10](10-form-project) - Form Project
- ✅ [11](11-file-handling) - File Handling
- ✅ [12](12-file-upload) - File Upload
- ✅ [13](13-sessions-cookies) - Sessions & Cookies
- ✅ [14](14-password-hashing) - Password Hashing
- ⬜ [15](15-login-system) - Login System (Student Task)
- ✅ [16](16-database-basics) - Database Basics
- ✅ [17](17-sql-crud) - SQL CRUD
- ✅ [18](18-php-mysql) - PHP-MySQL Connection
- ✅ [19](19-insert-data) - Insert Data
- ✅ [20](20-fetch-data) - Fetch Data

## Learning Plan Structure

| Phase       | Days  | Topics                      |
| ----------- | ----- | --------------------------- |
| **Phase 1** | 1-10  | PHP Fundamentals            |
| **Phase 2** | 11-15 | Files & Sessions            |
| **Phase 3** | 16-25 | MySQL + PHP                 |
| **Phase 4** | 26-40 | CRUD Project (Notes App)    |
| **Phase 5** | 41-45 | Best Practices & Next Steps |

## Phase Breakdown

### Phase 1: PHP Fundamentals (Day 1-10)

- PHP syntax, variables, data types
- Operators and control structures
- Loops and arrays
- Functions (user-defined & built-in)
- Forms, `$_GET`, `$_POST`
- Form validation & sanitization

### Phase 2: Working with Files & Sessions (Day 11-15)

- File handling (`fopen`, `fwrite`, `fread`)
- File uploads with validation
- Sessions & cookies
- Password hashing (`password_hash`, `password_verify`)

### Phase 3: MySQL + PHP (Day 16-25)

- Database fundamentals
- SQL basics (CRUD operations)
- PHP-MySQL connection (mysqli/PDO)
- Prepared statements (SQL injection prevention)
- Pagination & search

### Phase 4: CRUD Project - Simple Notes App (Day 26-40)

A beginner-friendly notes application demonstrating:

- User authentication (Register, Login, Logout)
- Full CRUD functionality
- Pin & archive notes
- Search & filter by category
- Color-coded notes
- Responsive design
- Security best practices

## Tech Stack

- **Backend:** PHP
- **Database:** MySQL, SQLite
- **Database Library:** PDO
- **Local Server:** XAMPP / MAMP
- **Frontend:** HTML, CSS

## Getting Started

1. Install [XAMPP](https://www.apachefriends.org/) or [MAMP](https://www.mamp.info/)
2. Clone this repository to your `htdocs` folder
3. Start Apache and MySQL services
4. Navigate to any lesson folder and run: `php -S localhost:8000`

## Project Structure

```
corephp/
├── 01-hello-world/
├── 02-variables-datatypes/
├── 03-operators-conditionals/
├── 04-loops/
├── 05-arrays/
├── 06-functions/
├── 07-builtin-functions/
├── 08-forms/
├── 09-form-validation/
├── 10-form-project/
├── 11-file-handling/
├── 12-file-upload/
├── 13-sessions-cookies/
├── 14-password-hashing/
├── 15-login-system/        # Student Task
├── 16-database-basics/
├── 17-sql-crud/
├── 18-php-mysql/
├── 19-insert-data/
├── 20-fetch-data/
├── DATABASE_SETUP.md
├── MYSQL_SETUP.md
├── SQL_BEGINNERS_GUIDE.md
├── php-learning-plan.md
└── README.md
```

## Goals

By the end of this 45-day journey:

- Build PHP web apps confidently
- Create secure CRUD applications
- Understand backend fundamentals
- Be prepared for Junior PHP / Backend Developer roles

## Resources

- [PHP Official Documentation](https://www.php.net/docs.php)
- [W3Schools PHP Tutorial](https://www.w3schools.com/php/)
- [PHP The Right Way](https://phptherightway.com/)

## Contributing

Found a bug in an example, a typo, or have a better exercise idea? Contributions are welcome:

1. Fork the repo and create a branch: `git checkout -b fix/day-09-validation`
2. Make your change and commit it with a clear message
3. Open a pull request describing what you changed and why

## License

Released under the [MIT License](LICENSE) — free to use, adapt and teach from. Attribution is appreciated.

---

<p align="center">Made with ❤️ by <a href="https://github.com/kirangautam45">Kiran Gautam</a> · <a href="https://kirangtm.com.np/">kirangtm.com.np</a><br>⭐ Star the repo if you found it useful!</p>
