# Day 14: Password Security in PHP
## 50-Minute Lesson Plan

### Learning Objectives
By the end of this lesson, students will be able to:
1. Understand why password hashing is critical
2. Use password_hash() and password_verify()
3. Implement secure registration and login
4. Validate password strength

### Lesson Structure (50 minutes)

| Time | Topic | File |
|------|-------|------|
| 0-5 min | Why hash passwords? | Lecture |
| 5-15 min | Hash & verify basics | 01_hashing.php |
| 15-30 min | Registration system | 02_register.php |
| 30-45 min | Login with verification | 03_login.php |
| 45-50 min | Practice & Q&A | - |

### The Golden Rules

1. **NEVER** store passwords in plain text
2. **NEVER** use MD5 or SHA1 for passwords (too fast to crack)
3. **ALWAYS** use `password_hash()` with `PASSWORD_DEFAULT`
4. **ALWAYS** use `password_verify()` to check passwords

### Key Functions

```php
// Hashing (during registration)
$hash = password_hash($password, PASSWORD_DEFAULT);

// Verifying (during login)
if (password_verify($password, $storedHash)) {
    // Password correct!
}

// Check if rehash needed (algorithm update)
if (password_needs_rehash($hash, PASSWORD_DEFAULT)) {
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    // Update stored hash
}
```

### Why password_hash() is Secure

1. **Bcrypt algorithm** - Intentionally slow
2. **Automatic salting** - Each hash is unique
3. **Cost factor** - Adjustable difficulty
4. **Future-proof** - PASSWORD_DEFAULT updates automatically

### Common Mistakes to Avoid

- Storing plain text passwords
- Using reversible encryption
- Using fast hashes (MD5, SHA1)
- Using the same salt for all passwords
- Checking passwords with `==` instead of `password_verify()`

### Running the Examples
```bash
cd /Users/kiran/Developer/codephp/days/day14-password-lesson
php 01_hashing.php
php -S localhost:8014  # For web examples
```
