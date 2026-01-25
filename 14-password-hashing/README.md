# Password Security in PHP

### Key Functions

```php
// Hash (registration)
$hash = password_hash($password, PASSWORD_DEFAULT);

// Verify (login)
if (password_verify($password, $storedHash)) {
    // Password correct!
}
```

### Files

| File | Description |
|------|-------------|
| index.php | Basic demo - hash & verify with interactive test |
| 01_hashing.php | Why hashing, multiple hash demo, verification table, hash structure |
| 02_register.php | User registration with validation and password hashing |
| 03_login.php | User login with password_verify() |

### index.php
- Shows password and its hash
- Displays key code snippet
- Interactive form to test password matching

### 01_hashing.php
- Explains why hashing is important (plain text vs MD5 vs bcrypt)
- Shows same password creates different hashes
- Verification table with pass/fail examples
- Hash structure breakdown ($2y, cost, salt, hash)

### 02_register.php
- Registration form (username, email, password)
- Input validation (length, email format)
- Uses `password_hash()` to store password
- Saves users to JSON file

### 03_login.php
- Login form (username, password)
- Uses `password_verify()` to check password
- Session management (login/logout)
- Shows logged-in user info

### Golden Rules

1. **NEVER** store passwords in plain text
2. **NEVER** use MD5 or SHA1 for passwords
3. **ALWAYS** use `password_hash()` with `PASSWORD_DEFAULT`
4. **ALWAYS** use `password_verify()` to check passwords

### Run

```bash
php -S localhost:8014
```

Then open http://localhost:8014
