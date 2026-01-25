# Day 10: Mini Project - Safe Contact Form

## Project Overview

Today you'll apply everything you've learned about forms, validation, and sanitization to build a complete, secure contact form.

---

## Learning Objectives

By the end of today, you will:

- Combine form handling, validation, and sanitization
- Build a real-world contact form from scratch
- Apply security best practices
- Handle success and error states properly

---

## Project Requirements

### The Contact Form Must Have:

1. **Name** - Required, 2-50 characters
2. **Email** - Required, valid email format
3. **Subject** - Required, select from dropdown
4. **Message** - Required, 10-1000 characters
5. **Submit Button**

### Features to Implement:

- All input must be validated before processing
- All output must be sanitized to prevent XSS
- Form should retain values on error (sticky form)
- Display clear error messages
- Show success message after valid submission
- Display submitted data safely

---

## Security Checklist

```
[ ] Validate all required fields
[ ] Check email format
[ ] Validate string lengths
[ ] Sanitize with htmlspecialchars() before display
[ ] Use ENT_QUOTES and UTF-8 encoding
[ ] Trim whitespace from inputs
[ ] Escape all user data in HTML output
```

---

## Files in This Day

| File                   | Description                  |
| ---------------------- | ---------------------------- |
| `01-contact-form.php`  | Complete working solution    |
| `02-your-solution.php` | Template for you to complete |

---

## How to Test

1. Start your PHP server:

   ```bash
   php -S localhost:8000
   ```

2. Open in browser:

   ```
   http://localhost:8000/01-contact-form.php
   ```

3. Test cases to try:
   - Submit empty form (should show errors)
   - Enter invalid email (should show error)
   - Enter very short message (should show error)
   - Enter valid data (should show success)
   - Try entering `<script>alert('XSS')</script>` in fields

---

## Step-by-Step Guide

### Step 1: Form Structure

```php
<form method="POST" action="">
    <input type="text" name="name">
    <input type="email" name="email">
    <select name="subject">...</select>
    <textarea name="message"></textarea>
    <button type="submit">Send</button>
</form>
```

### Step 2: Check if Form Submitted

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form
}
```

### Step 3: Get and Trim Input

```php
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = $_POST['subject'] ?? '';
$message = trim($_POST['message'] ?? '');
```

### Step 4: Validate Each Field

```php
$errors = [];

if (empty($name)) {
    $errors['name'] = 'Name is required';
} elseif (strlen($name) < 2 || strlen($name) > 50) {
    $errors['name'] = 'Name must be 2-50 characters';
}

// Continue for other fields...
```

### Step 5: Process or Show Errors

```php
if (empty($errors)) {
    // Success! Process the form
    $success = true;
} else {
    // Show errors to user
}
```

### Step 6: Display Data Safely

```php
// ALWAYS use htmlspecialchars when displaying user input
echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
```

---

## Common Mistakes to Avoid

1. **Forgetting to sanitize output**

   ```php
   // BAD - XSS vulnerability!
   echo $name;

   // GOOD
   echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
   ```

2. **Not trimming input**

   ```php
   // BAD - spaces count as content
   $name = $_POST['name'];

   // GOOD
   $name = trim($_POST['name'] ?? '');
   ```

3. **Checking empty before isset**

   ```php
   // BAD - may cause notice
   if (empty($_POST['name'])) { }

   // GOOD - use null coalescing
   $name = $_POST['name'] ?? '';
   if (empty($name)) { }
   ```

---

## Bonus Challenges

1. Add a phone number field with format validation
2. Add a "How did you hear about us?" radio button group
3. Add a checkbox for "Subscribe to newsletter"
4. Save submissions to a text file
5. Add CSRF token protection

---

## Key Takeaways

| Concept               | Purpose                 |
| --------------------- | ----------------------- |
| `$_POST`              | Get form data           |
| `trim()`              | Remove extra whitespace |
| `empty()`             | Check if value is empty |
| `strlen()`            | Check string length     |
| `filter_var()`        | Validate email format   |
| `htmlspecialchars()`  | Prevent XSS attacks     |
| `ENT_QUOTES, 'UTF-8'` | Proper encoding options |

---

## What You've Learned (Days 1-10)

Congratulations! You've completed the first 10 days of PHP fundamentals:

1. **Day 1-3:** PHP basics, variables, operators
2. **Day 4:** Loops (for, while, foreach)
3. **Day 5:** Conditional statements
4. **Day 6:** Functions
5. **Day 7:** Built-in functions & includes
6. **Day 8:** Forms & GET/POST
7. **Day 9:** Validation & sanitization
8. **Day 10:** Complete form project

You now have the foundation to build secure PHP web applications!

---

**← Previous:** Day 09 - Validation & Sanitization | **Next:** Day 11 - Sessions & Cookies →
