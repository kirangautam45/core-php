# Day 19: Insert Form Data into Database (50 min)

## ⏱️ Lesson Plan

| Time | Topic |
|------|-------|
| 0-5 min | Setup |
| 5-20 min | Basic Form → Database |
| 20-35 min | Form Validation |
| 35-50 min | Complete Registration Form |

---

## 🛠️ Setup (5 min)

### Database
```sql
CREATE DATABASE IF NOT EXISTS day19_practice;
USE day19_practice;

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### db_config.php
```php
<?php
$pdo = new PDO(
    "mysql:host=localhost;dbname=day19_practice;charset=utf8mb4",
    "root", "",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);
```

---

## 📝 Basic Form → Database (15 min)

### 1_basic_form.php
```php
<?php
require 'db_config.php';

$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $msg = trim($_POST['message']);

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $msg]);

    $message = "Thank you! Your message was saved.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
    <h1>Contact Us</h1>

    <?php if ($message): ?>
        <p style="color: green;"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label>Name:</label><br>
            <input type="text" name="name" required>
        </p>
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" required>
        </p>
        <p>
            <label>Message:</label><br>
            <textarea name="message" required></textarea>
        </p>
        <button type="submit">Send</button>
    </form>
</body>
</html>
```

---

## ✅ Form Validation (15 min)

### 2_validation.php
```php
<?php
require 'db_config.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and clean input
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($message)) {
        $errors[] = "Message is required";
    } elseif (strlen($message) < 10) {
        $errors[] = "Message must be at least 10 characters";
    }

    // If no errors, save to database
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        $success = true;

        // Clear form
        $name = $email = $message = '';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Form with Validation</title>
    <style>
        .error { color: red; }
        .success { color: green; }
        input, textarea { width: 300px; padding: 8px; margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Contact Us</h1>

    <?php if ($success): ?>
        <p class="success">✓ Message sent successfully!</p>
    <?php endif; ?>

    <?php if ($errors): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p>✗ <?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <p>
            <label>Name: *</label><br>
            <input type="text" name="name" value="<?= htmlspecialchars($name ?? '') ?>">
        </p>
        <p>
            <label>Email: *</label><br>
            <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
        </p>
        <p>
            <label>Message: *</label><br>
            <textarea name="message" rows="4"><?= htmlspecialchars($message ?? '') ?></textarea>
        </p>
        <button type="submit">Send Message</button>
    </form>
</body>
</html>
```

---

## 👤 Complete Registration Form (15 min)

### First, create users table:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 3_registration.php
```php
<?php
require 'db_config.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    // Validation
    if (empty($username)) {
        $errors['username'] = "Username is required";
    } elseif (strlen($username) < 3) {
        $errors['username'] = "Username must be at least 3 characters";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters";
    }

    if ($password !== $confirm) {
        $errors['confirm'] = "Passwords do not match";
    }

    // Check if username/email exists
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors['email'] = "Username or email already exists";
        }
    }

    // Register user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword]);

        $success = true;
        $username = $email = '';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        input.error { border-color: red; }
        .error-msg { color: red; font-size: 14px; }
        .success { background: #d4edda; padding: 15px; border-radius: 4px; color: #155724; }
        button { background: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <h1>Create Account</h1>

    <?php if ($success): ?>
        <div class="success">✓ Registration successful!</div>
    <?php else: ?>

    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($username ?? '') ?>">
            <?php if (isset($errors['username'])): ?>
                <span class="error-msg"><?= $errors['username'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
            <?php if (isset($errors['email'])): ?>
                <span class="error-msg"><?= $errors['email'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password">
            <?php if (isset($errors['password'])): ?>
                <span class="error-msg"><?= $errors['password'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password">
            <?php if (isset($errors['confirm'])): ?>
                <span class="error-msg"><?= $errors['confirm'] ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Register</button>
    </form>
    <?php endif; ?>
</body>
</html>
```

---

## 📝 Key Security Points

| Do This ✅ | Not This ❌ |
|-----------|-------------|
| `password_hash($password, PASSWORD_DEFAULT)` | Store plain text passwords |
| Prepared statements `execute([$var])` | Direct SQL `"WHERE id = $id"` |
| `htmlspecialchars()` when displaying | Echo user input directly |
| Validate all input | Trust user input |

---

## 📁 Files in This Directory

| File | Purpose |
|------|---------|
| `database_setup.sql` | Create sample database |
| `db_config.php` | PDO connection config |
| `1_basic_form.php` | Simple form to database |
| `2_validation.php` | Form with validation |
| `3_registration.php` | User registration form |

---

## ➡️ Next: Day 20 - Fetch & Display Data
