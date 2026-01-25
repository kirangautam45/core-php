# Day 13: Sessions & Cookies in PHP
## 50-Minute Lesson Plan

### Learning Objectives
By the end of this lesson, students will be able to:
1. Understand the difference between sessions and cookies
2. Create and manage PHP sessions
3. Build a shopping cart using sessions
4. Set and read cookies for user preferences

### Lesson Structure (50 minutes)

| Time | Topic | File |
|------|-------|------|
| 0-5 min | Sessions vs Cookies overview | Lecture |
| 5-15 min | Session basics | 01_sessions.php |
| 15-30 min | Shopping cart example | 02_cart.php |
| 30-45 min | Cookies & login system | 03_cookies.php, 04_login.php |
| 45-50 min | Practice & Q&A | - |

### Sessions vs Cookies Comparison

| Feature | Sessions | Cookies |
|---------|----------|---------|
| Storage | Server | Browser |
| Size limit | No practical limit | ~4KB |
| Security | More secure | Less secure |
| Lifetime | Until browser closes* | Configurable |
| Access | Server only | Server & Client JS |

*Sessions can be configured to persist

### Key Session Functions

```php
session_start();              // Start/resume session (MUST be first!)
$_SESSION['key'] = 'value';   // Store data
$value = $_SESSION['key'];    // Read data
unset($_SESSION['key']);      // Remove one item
session_destroy();            // End session
session_regenerate_id(true);  // Security: new session ID
```

### Key Cookie Functions

```php
// Set cookie (expires in 30 days)
setcookie('name', 'value', time() + (30 * 24 * 60 * 60));

// Read cookie
$value = $_COOKIE['name'] ?? 'default';

// Delete cookie (set expiration in past)
setcookie('name', '', time() - 3600);
```

### Running the Examples
```bash
cd /Users/kiran/Developer/codephp/days/day13-sessions-lesson
php -S localhost:8013
# Open browser to http://localhost:8013
```

### Important Notes
- `session_start()` must be called before ANY output
- Cookies are sent with HTTP headers (also before output)
- Sessions use a cookie (PHPSESSID) to track the session ID
