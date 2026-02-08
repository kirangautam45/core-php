# Test Project: User Profile System

## Overview

Build a complete user profile system with registration, login, profile picture upload, and password change functionality.

## Prerequisites

You should have completed these lessons:
- 08-forms - Form handling
- 09-form-validation - Input validation
- 11-file-handling - JSON read/write
- 12-file-upload - File uploads
- 13-sessions-cookies - Sessions
- 14-password-hashing - password_hash(), password_verify()


---

## Project Structure

Create these files:

```
test-user-profile/
├── uploads/            # Profile pictures (create this folder)
├── users.json          # User data storage
├── index.php           # Entry point (redirects based on login status)
├── register.php        # Registration with profile picture
├── login.php           # Login page
├── profile.php         # View/edit profile (protected)
├── change-password.php # Change password (protected)
└── logout.php          # Destroy session
```

---

## Entry Point: `index.php`

The entry point for the application. It checks session status and redirects accordingly:

```php
<?php
session_start();

// If logged in, redirect to profile
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

// If not logged in, redirect to login
header('Location: login.php');
exit;
```

This allows users to visit the root URL and be automatically directed to the appropriate page.

---

## Step 1: Create `users.json`

Store users as an array of objects. Each user should have:
- `username` (string, unique)
- `password` (string, hashed)
- `profile_pic` (string, filename or empty)
- `created_at` (string, date)

Example structure:
```json
{
    "admin": {
        "password": "$2y$12$hashedPasswordHere...",
        "email": "admin@example.com",
        "profile_pic": "admin_1234567890.jpg",
        "created_at": "2024-01-29"
    }
}
```

---

## Step 2: Create `register.php`

### PHP Logic:

1. Start session
2. If already logged in, redirect to `profile.php`
3. On form submit (POST):
   - Get username, password, confirm password
   - Validate:
     - Username is not empty and unique
     - Password is at least 6 characters
     - Passwords match
   - Handle profile picture upload:
     - Check if file was uploaded
     - Validate file type (jpg, jpeg, png, gif only)
     - Validate file size (max 2MB)
     - Generate unique filename: `{username}_{timestamp}.{extension}`
     - Move to `uploads/` folder
   - Hash the password using `password_hash()`
   - Save user to `users.json`
   - Redirect to `login.php`

### HTML Form:

- Username input (text, required)
- Email input (email, required)
- Password input (password, required)
- Confirm Password input (password, required)
- Profile Picture input (file, optional)
- Submit button
- Link to login page

**Important:** Form must have `enctype="multipart/form-data"` for file upload!

---

## Step 3: Create `login.php`

### PHP Logic:

1. Start session
2. If already logged in, redirect to `profile.php`
3. On form submit (POST):
   - Get username and password
   - Load users from `users.json`
   - Check if user exists
   - Verify password using `password_verify()`
   - If valid: store username in `$_SESSION['user']`, redirect to `profile.php`
   - If invalid: show error message

### HTML Form:

- Username input (text, required)
- Password input (password, required)
- Remember Me checkbox (optional)
- Submit button
- Link to register page

---

## Step 4: Create `profile.php` (Protected Page)

### PHP Logic:

1. Start session
2. **Check if logged in** - if not, redirect to `login.php`
3. Load current user data from `users.json`

### HTML:

- Display username
- Display profile picture (or default placeholder if none)
- Display account creation date
- Link to change password
- Logout button

**Hint for displaying image:**
```php
<?php if (!empty($user['profile_pic'])): ?>
    <img src="uploads/<?= $user['profile_pic'] ?>" width="150">
<?php else: ?>
    <p>No profile picture</p>
<?php endif; ?>
```

---

## Step 5: Create `change-password.php` (Protected Page)

### PHP Logic:

1. Start session
2. **Check if logged in** - if not, redirect to `login.php`
3. On form submit (POST):
   - Get current password, new password, confirm new password
   - Load users from `users.json`
   - Verify current password using `password_verify()`
   - Validate new password (min 6 chars, must match confirm)
   - Hash new password and update in `users.json`
   - Show success message or redirect to profile

### HTML Form:

- Current Password input (password, required)
- New Password input (password, required)
- Confirm New Password input (password, required)
- Submit button
- Link back to profile

---

## Step 6: Create `logout.php`

1. Start session
2. Clear session: `$_SESSION = []`
3. Destroy session: `session_destroy()`
4. Redirect to `login.php`

---

## Validation Rules Summary

| Field | Rules |
|-------|-------|
| Username | Required, unique, no spaces |
| Email | Required, valid format, unique |
| Password | Required, min 6 characters |
| Confirm Password | Must match password |
| Profile Picture | Optional, jpg/jpeg/png/gif only, max 2MB |

---

## File Upload Hints

### Check file type:
```php
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
$extension = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
if (!in_array($extension, $allowed)) {
    $error = 'Only JPG, PNG, GIF allowed!';
}
```

### Check file size (2MB = 2097152 bytes):
```php
if ($_FILES['profile_pic']['size'] > 2097152) {
    $error = 'File too large! Max 2MB.';
}
```

### Move uploaded file:
```php
$filename = $username . '_' . time() . '.' . $extension;
move_uploaded_file($_FILES['profile_pic']['tmp_name'], 'uploads/' . $filename);
```

---

## Key Functions Reference

| Function | Purpose |
|----------|---------|
| `password_hash($pw, PASSWORD_DEFAULT)` | Hash a password |
| `password_verify($pw, $hash)` | Verify password against hash |
| `file_get_contents()` | Read file as string |
| `file_put_contents()` | Write string to file |
| `json_decode($json, true)` | Convert JSON to array |
| `json_encode($arr, JSON_PRETTY_PRINT)` | Convert array to JSON |
| `$_FILES['name']` | Access uploaded file info |
| `move_uploaded_file()` | Move uploaded file to destination |
| `pathinfo($file, PATHINFO_EXTENSION)` | Get file extension |

---

## Testing Checklist

- [ ] Can register new user without profile picture
- [ ] Can register new user with profile picture
- [ ] Cannot register with existing username
- [ ] Cannot register with existing email
- [ ] Cannot register with invalid email format
- [ ] Cannot register with mismatched passwords
- [ ] Cannot register with password less than 6 chars
- [ ] Cannot upload non-image files
- [ ] Cannot upload files larger than 2MB
- [ ] Can login with correct credentials
- [ ] Cannot login with wrong password
- [ ] Remember Me keeps user logged in after closing browser
- [ ] Profile page shows user info, email, and picture
- [ ] Can update profile picture from profile page
- [ ] Old profile picture is deleted when uploading new one
- [ ] Cannot access profile.php without login
- [ ] Can change password with correct current password
- [ ] Cannot change password with wrong current password
- [ ] Logout clears session, cookie, and redirects to login
- [ ] Flash messages display for success/error actions

---

## Running the Project

```bash
cd test-user-profile
php -S localhost:8080
```

Open browser: http://localhost:8080 (redirects to login or profile based on session)

---

## Bonus Challenges (Implemented)

All bonus features have been implemented:

1. **Update profile picture from profile page** - Form on profile.php to upload new picture
2. **"Remember Me" checkbox** - Uses secure token stored in cookie (30 days) and users.json
3. **Email field in registration** - Required field with validation and uniqueness check
4. **Delete old profile picture** - Old file is deleted when uploading a new one
5. **Flash messages** - Session-based success/error notifications across pages

Good luck!

---

## Docker Support

### Running Locally with Docker Compose
1. **Start the application:**
   ```bash
   docker-compose up --build
   ```
2. **Access the site:**
   Open [http://localhost:8080](http://localhost:8080)

### Running Manually with Docker
1. **Build the image:**
   ```bash
   docker build -t test-user-profile .
   ```
2. **Run the container:**
   ```bash
   docker run -p 8080:80 test-user-profile
   ```

### Deployment on Railway
1. Push your code to GitHub.
2. Connect your repository to Railway.
3. Railway will auto-detect the `Dockerfile` and deploy.
   > **Note:** Since this app uses a local `users.json` file, data will be lost on every redeploy unless you configure a persistent volume or switch to a database.

## Supabase Migration

The project is configured to use Supabase (PostgreSQL + Storage).

### 1. Environment Variables
Create a `.env` file (or set Railway variables) with:
```bash
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_KEY=your-anon-or-service-key
# Optional (if not using standard connection logic):
# DATABASE_URL=postgres://postgres...
```

### 2. Database Schema
Run this SQL in your Supabase SQL Editor:
```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username TEXT UNIQUE NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    profile_pic TEXT,
    remember_token TEXT,
    created_at TIMESTAMP DEFAULT NOW()
);
```

### 3. Storage
Create a public storage bucket named `avatars`.

