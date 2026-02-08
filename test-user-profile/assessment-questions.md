# User Profile System - Assessment Questions with Answers

Use these questions during code reviews to verify student understanding.

---

## Section 1: Sessions & Authentication

### Basic Questions

**1. What does `session_start()` do? Why must it be at the top of every file?**
> It initializes the session system and loads existing session data from the server. It must be at the top because it sends headers to the browser, and headers must be sent before any output (HTML, whitespace, etc.).

**2. How do you check if a user is logged in?**
> Check if the session variable exists: `isset($_SESSION['user'])`

**3. What is stored in `$_SESSION['user']` after login?**
> The username of the logged-in user (a string).

**4. Why do we use `exit` after `header('Location: ...')`?**
> Because `header()` only sends a redirect instruction - PHP continues executing code below it. Without `exit`, the rest of the page would still run (security risk - protected content could be processed).

### Intermediate Questions

**5. What happens if you forget `session_start()` on profile.php?**
> `$_SESSION['user']` will not exist (undefined), so the login check will fail and redirect to login even for logged-in users. The session data won't be accessible.

**6. How does logout.php destroy the session? What are the two steps?**
> 1. `$_SESSION = []` - Clears all session variables
> 2. `session_destroy()` - Destroys the session file on the server

**7. Why do we redirect instead of showing content directly after login?**
> To follow the POST-Redirect-GET pattern. This prevents form resubmission if the user refreshes the page, and provides a clean URL in the browser.

### Advanced Questions

**8. What's the difference between `$_SESSION = []` and `session_destroy()`?**
> `$_SESSION = []` empties the session array but keeps the session active. `session_destroy()` deletes the session file on the server. For complete logout, you need both.

**9. How would you implement session timeout (auto-logout after 30 minutes)?**
> Store login timestamp in session: `$_SESSION['login_time'] = time()`. On each page, check: `if (time() - $_SESSION['login_time'] > 1800) { /* logout */ }`. Optionally update timestamp on activity.

**10. What security risk exists if session IDs are predictable?**
> Session hijacking - an attacker could guess another user's session ID and impersonate them without knowing their password.

---

## Section 2: Password Security

### Basic Questions

**1. Why don't we store passwords as plain text?**
> If the database/file is compromised, attackers would have everyone's actual passwords. Since people reuse passwords, this could compromise their other accounts too.

**2. What function do we use to hash passwords?**
> `password_hash($password, PASSWORD_DEFAULT)`

**3. What function verifies a password against a hash?**
> `password_verify($password, $hash)` - returns true or false

### Intermediate Questions

**4. Why can't we just compare hashes directly with `===`?**
> Because `password_hash()` generates a different hash each time (due to random salt). The same password produces different hashes. `password_verify()` knows how to extract the salt and compare correctly.

**5. What algorithm does `PASSWORD_DEFAULT` use currently?**
> bcrypt (as of PHP 7.x/8.x). This may change in future PHP versions to stronger algorithms, which is why we use `PASSWORD_DEFAULT` instead of hardcoding.

**6. Why does the same password produce different hashes each time?**
> Because a random "salt" is generated and included in the hash. This prevents rainbow table attacks and ensures identical passwords have different hashes.

### Advanced Questions

**7. What is a "salt" and why is it important?**
> A salt is random data added to the password before hashing. It prevents: 1) Rainbow table attacks (precomputed hash lookups), 2) Identifying users with the same password (their hashes will differ).

**8. Why is MD5 or SHA1 not suitable for password hashing?**
> They're designed to be fast, which makes brute-force attacks easy. bcrypt is intentionally slow. Also, MD5/SHA1 don't include automatic salting.

**9. How would you force users to rehash passwords if the algorithm changes?**
> Use `password_needs_rehash($hash, PASSWORD_DEFAULT)` on login. If it returns true, rehash with new algorithm and save: `$newHash = password_hash($password, PASSWORD_DEFAULT)`

---

## Section 3: File Upload

### Basic Questions

**1. What does `enctype="multipart/form-data"` do?**
> It tells the browser to encode the form data in a format that supports file uploads. Without it, only the filename would be sent, not the actual file content.

**2. How do you access uploaded file information in PHP?**
> Through the `$_FILES` superglobal. Example: `$_FILES['profile_pic']['name']`, `$_FILES['profile_pic']['tmp_name']`, `$_FILES['profile_pic']['size']`, `$_FILES['profile_pic']['error']`

**3. What does `move_uploaded_file()` do?**
> Moves an uploaded file from the temporary directory (where PHP stores it initially) to a permanent location on your server.

### Intermediate Questions

**4. Why do we check file extension before saving?**
> To prevent users from uploading malicious files (like .php scripts) that could be executed on the server if accessed directly.

**5. Why do we rename uploaded files instead of keeping original names?**
> 1) Prevent overwriting existing files with same name, 2) Avoid special characters/spaces causing issues, 3) Prevent path traversal attacks (../../../etc/passwd), 4) Make filenames predictable for our system.

**6. What does `$_FILES['profile_pic']['error']` tell us?**
> Upload status code. `UPLOAD_ERR_OK` (0) means success. Other values indicate errors: file too large, partial upload, no file selected, etc.

### Advanced Questions

**7. Why is checking only file extension not fully secure?**
> Attackers can rename malicious files (evil.php → evil.jpg). The extension doesn't guarantee file content. Should also check MIME type and/or file headers.

**8. How would you validate that an uploaded file is actually an image?**
> Use `getimagesize($file)` - returns false for non-images. Or check MIME type with `finfo_file()`. Or use `exif_imagetype()` which checks actual file headers.

**9. What's the risk of storing uploaded files in a web-accessible directory?**
> If a malicious PHP file is uploaded and accessed via URL, it would execute on the server. Solutions: store outside web root, disable PHP execution in uploads folder, or use a separate domain for static files.

---

## Section 4: Form Handling & Validation

### Basic Questions

**1. What's the difference between GET and POST methods?**
> GET: Data in URL, visible, bookmarkable, limited size, for retrieving data. POST: Data in request body, hidden, larger size limit, for submitting/changing data. Use POST for login/forms with sensitive data.

**2. How do you check if a form was submitted?**
> Check the request method: `$_SERVER['REQUEST_METHOD'] === 'POST'`

**3. What does `htmlspecialchars()` prevent?**
> XSS (Cross-Site Scripting) attacks. It converts special HTML characters to entities (< becomes &lt;) so user input is displayed as text, not executed as HTML/JavaScript.

### Intermediate Questions

**4. Why do we use `trim()` on username but not password?**
> Usernames shouldn't have leading/trailing spaces (user error). But passwords might intentionally contain spaces - trimming could lock users out of their accounts.

**5. What does `filter_var($email, FILTER_VALIDATE_EMAIL)` do?**
> Validates that a string looks like a valid email format. Returns the email if valid, or `false` if invalid. Checks for @ symbol, domain structure, etc.

**6. Why check if username exists before checking password length?**
> Order of validation matters for user experience. Check in logical order: required fields → format validation → business rules. Also prevents unnecessary processing.

### Advanced Questions

**7. What is CSRF and how would you prevent it?**
> Cross-Site Request Forgery - tricks logged-in users into submitting forms to your site from other sites. Prevent with: 1) Generate random token, store in session, 2) Include token in form as hidden field, 3) Verify token matches on submission.

**8. Why should validation happen server-side even if we have JavaScript validation?**
> JavaScript can be disabled or bypassed. Attackers can send requests directly to the server. Client-side validation is for UX only; server-side is for security.

**9. How would you prevent brute-force login attempts?**
> Options: 1) Rate limiting (max 5 attempts per minute), 2) Account lockout after X failed attempts, 3) CAPTCHA after failed attempts, 4) Increasing delays between attempts, 5) IP-based blocking.

---

## Section 5: JSON Data Storage

### Basic Questions

**1. What does `json_decode($data, true)` return? What does `true` do?**
> Converts JSON string to PHP data. The `true` parameter makes it return an associative array. Without it, you get a stdClass object.

**2. What does `JSON_PRETTY_PRINT` do in `json_encode()`?**
> Formats the JSON with indentation and line breaks for human readability. Without it, JSON is compact (single line).

**3. How do you check if a username already exists in the users array?**
> `isset($users[$username])` - since username is the key in our structure.

### Intermediate Questions

**4. What happens if `users.json` doesn't exist when you try to read it?**
> `file_get_contents()` returns false and triggers a warning. That's why we check: `file_exists($usersFile) ? json_decode(...) : []`

**5. Why do we use `file_put_contents()` instead of `fwrite()`?**
> It's simpler - handles opening, writing, and closing in one function. `fwrite()` requires manual `fopen()` and `fclose()`. For simple writes, `file_put_contents()` is cleaner.

**6. How is user data structured in `users.json`?**
> Associative array with username as key:
> ```json
> {
>   "username": {
>     "password": "hashed...",
>     "email": "user@example.com",
>     "profile_pic": "filename.jpg",
>     "created_at": "2024-01-29"
>   }
> }
> ```

### Advanced Questions

**7. What problem could occur if two users register at the exact same time?**
> Race condition: Both read the file, both add their user, both write. The second write overwrites the first user. One registration is lost.

**8. How would you implement file locking to prevent data corruption?**
> Use `flock()`:
> ```php
> $fp = fopen($file, 'c+');
> flock($fp, LOCK_EX); // Exclusive lock
> // Read, modify, write
> flock($fp, LOCK_UN); // Release lock
> fclose($fp);
> ```

**9. At what point would you switch from JSON to a database? Why?**
> When you need: 1) Multiple concurrent users (locking issues), 2) Large data sets (JSON loads entire file), 3) Complex queries (search, filter, join), 4) Better performance, 5) Data relationships. Generally, 100+ users or any production app.

---

## Section 6: Cookies & Remember Me

### Basic Questions

**1. What's the difference between sessions and cookies?**
> Sessions: Data stored on server, only ID in browser, expires when browser closes (by default). Cookies: Data stored in browser, sent with every request, can persist for days/years.

**2. How do you set a cookie in PHP?**
> `setcookie('name', 'value', time() + 3600, '/')` - name, value, expiry timestamp, path

**3. How do you delete a cookie?**
> Set it with past expiry time: `setcookie('name', '', time() - 3600, '/')`

### Intermediate Questions

**4. Why do we use a random token instead of storing username in the cookie?**
> Security. If someone steals the cookie, they only get a token that can be invalidated. Storing username would let them impersonate forever and we couldn't revoke access.

**5. What does the third parameter in `setcookie()` (expiry time) do?**
> Sets when the cookie expires (Unix timestamp). `time() + (30 * 24 * 60 * 60)` = 30 days from now. After expiry, browser automatically deletes the cookie.

**6. Why store the remember token in both cookie AND users.json?**
> To verify the token is valid. Cookie alone could be forged. We compare cookie token against stored token to authenticate. Also allows server to invalidate tokens.

### Advanced Questions

**7. What's the security risk of "Remember Me" functionality?**
> If device is stolen/shared, attacker has persistent access. If token is stolen (XSS, network sniffing), attacker can impersonate user. Should: use HTTPS, HttpOnly cookies, allow users to see/revoke active sessions.

**8. How would you invalidate all remember tokens when user changes password?**
> Delete or regenerate the `remember_token` field in users.json when password changes. The old cookie token won't match anymore, forcing re-login.

**9. Why use `bin2hex(random_bytes(32))` for the token?**
> `random_bytes(32)` generates 32 cryptographically secure random bytes. `bin2hex()` converts to readable hexadecimal string (64 chars). This creates an unguessable, unique token.

---

## Section 7: Code Flow Questions

### "Walk me through..." Questions

**1. Walk me through what happens when a user clicks "Register"**
> 1. Form submits POST to register.php
> 2. Server checks REQUEST_METHOD === POST
> 3. Get and trim form inputs
> 4. Load existing users from JSON
> 5. Validate: username not empty, no spaces, unique
> 6. Validate: email format, unique
> 7. Validate: password length, matches confirm
> 8. If file uploaded: validate type, size, move to uploads/
> 9. Hash password with password_hash()
> 10. Add user to array, save to JSON
> 11. Set flash message, redirect to login

**2. Walk me through the login process step by step**
> 1. Form submits POST to login.php
> 2. Get username and password from POST
> 3. Load users from JSON
> 4. Check if username exists in array
> 5. Use password_verify() to compare password with stored hash
> 6. If valid: set $_SESSION['user'] = username
> 7. If "Remember Me" checked: generate token, store in cookie and JSON
> 8. Redirect to profile.php
> 9. If invalid: show error message

**3. Walk me through how profile picture upload works**
> 1. Form with enctype="multipart/form-data" submits to profile.php
> 2. Check $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK
> 3. Get file extension with pathinfo()
> 4. Validate extension is in allowed list
> 5. Validate file size <= 2MB
> 6. If user has existing picture, delete it with unlink()
> 7. Generate new filename: username_timestamp.extension
> 8. Use move_uploaded_file() to save
> 9. Update user's profile_pic in JSON
> 10. Set flash message, redirect

**4. Walk me through what happens when visiting index.php**
> 1. session_start() initializes session
> 2. Check if $_SESSION['user'] is set
> 3. If logged in: redirect to profile.php
> 4. If not logged in: redirect to login.php
> 5. exit stops further execution

### "What if..." Questions

**1. What if a user tries to access profile.php without logging in?**
> The `isset($_SESSION['user'])` check fails, so they're redirected to login.php with `header('Location: login.php')` followed by `exit`.

**2. What if someone uploads a PHP file renamed to .jpg?**
> Our extension check would pass (it's .jpg), but it's not a real image. Better to also check with `getimagesize()`. If stored in web-accessible folder, risk depends on server config.

**3. What if the password is less than 6 characters?**
> The validation `strlen($password) < 6` catches it, sets `$error = 'Password must be at least 6 characters!'`, and the form is re-displayed with the error message.

**4. What if the email is already registered?**
> The loop checking `strtolower($existingUser['email']) === strtolower($email)` finds a match, sets error "Email already registered!", and registration fails.

### "Why did you..." Questions

**1. Why did you check `$_FILES['profile_pic']['error'] === UPLOAD_ERR_OK`?**
> To confirm the file uploaded successfully. Other error codes indicate problems: file too large, partial upload, no file sent, etc. Only proceed if upload succeeded.

**2. Why did you use `strtolower()` on the file extension?**
> File extensions can be uppercase (.JPG) or lowercase (.jpg). Converting to lowercase ensures our check works regardless of how the user's file was named.

**3. Why did you include timestamp in the profile picture filename?**
> To make filenames unique. Without it, if a user uploads multiple pictures, they'd overwrite each other. Also helps with browser caching - new filename = browser fetches new image.

**4. Why did you use `password_hash()` instead of `md5()`?**
> `password_hash()` uses bcrypt which is slow (resistant to brute force), includes automatic salting, and is designed for passwords. MD5 is fast (bad for passwords), has no salt, and has known vulnerabilities.

---

## Section 8: Live Modification Tasks

Ask the student to make these changes on the spot:

### Easy (2-3 minutes)

**Change minimum password length from 6 to 8 characters**
> In register.php, change: `strlen($password) < 6` to `strlen($password) < 8`
> Also update the error message and placeholder text.

**Add a maximum length validation for username (20 chars)**
> Add validation: `} elseif (strlen($username) > 20) { $error = 'Username must be 20 characters or less!'; }`

**Change the "Remember Me" cookie duration from 30 to 7 days**
> In login.php, change: `time() + (30 * 24 * 60 * 60)` to `time() + (7 * 24 * 60 * 60)`

### Medium (5-7 minutes)

**Add a "Confirm Email" field to registration**
> 1. Add input field in HTML: `<input type="email" name="confirm_email" placeholder="Confirm Email" required>`
> 2. Get value: `$confirmEmail = trim($_POST['confirm_email'] ?? '');`
> 3. Add validation: `} elseif ($email !== $confirmEmail) { $error = 'Emails do not match!'; }`

**Display "Last login" date on profile page**
> 1. In login.php after successful login: `$users[$username]['last_login'] = date('Y-m-d H:i:s');` and save JSON
> 2. In profile.php display: `<p>Last login: <?= htmlspecialchars($user['last_login'] ?? 'First login') ?></p>`

**Add a character counter below password field**
> Add JavaScript:
> ```html
> <input type="password" name="password" id="password" oninput="updateCounter()">
> <small id="counter">0 characters</small>
> <script>
> function updateCounter() {
>   document.getElementById('counter').textContent =
>     document.getElementById('password').value.length + ' characters';
> }
> </script>
> ```

### Hard (10+ minutes)

**Prevent the same email from registering twice (case-insensitive)**
> Already implemented! The loop uses `strtolower()` on both emails:
> ```php
> foreach ($users as $existingUser) {
>     if (isset($existingUser['email']) && strtolower($existingUser['email']) === strtolower($email)) {
>         $error = 'Email already registered!';
>         break;
>     }
> }
> ```

**Add rate limiting: block login after 5 failed attempts**
> ```php
> // At top of login.php
> $attempts = $_SESSION['login_attempts'] ?? 0;
> $lockout_time = $_SESSION['lockout_time'] ?? 0;
>
> if ($attempts >= 5 && time() < $lockout_time) {
>     $error = 'Too many attempts. Try again in ' . ($lockout_time - time()) . ' seconds.';
> } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
>     // ... existing login code ...
>     if (/* login failed */) {
>         $_SESSION['login_attempts'] = $attempts + 1;
>         if ($_SESSION['login_attempts'] >= 5) {
>             $_SESSION['lockout_time'] = time() + 300; // 5 minutes
>         }
>     } else {
>         $_SESSION['login_attempts'] = 0; // Reset on success
>     }
> }
> ```

**Allow users to delete their account from profile page**
> ```php
> // In profile.php, handle POST for delete
> if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
>     // Delete profile picture if exists
>     if (!empty($user['profile_pic'])) {
>         unlink(__DIR__ . '/uploads/' . $user['profile_pic']);
>     }
>     // Remove user from array
>     unset($users[$username]);
>     file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
>     // Clear session and redirect
>     session_destroy();
>     header('Location: login.php');
>     exit;
> }
> ```
> Add button: `<form method="POST" onsubmit="return confirm('Are you sure?');"><button name="delete_account">Delete Account</button></form>`

---

## Section 9: Debugging Challenges

Introduce these bugs and ask them to fix:

### Syntax Errors

**1. Remove semicolon after `session_start()`**
> Error: Parse error, unexpected token
> Fix: Add semicolon back: `session_start();`

**2. Change `===` to `=` in password verification**
> Bug: `if (password_verify($password, $hash) = true)`
> Problem: Assignment instead of comparison, always evaluates to true
> Fix: Use `===` or just `if (password_verify($password, $hash))`

**3. Remove closing `?>` and add extra whitespace after it**
> Problem: Whitespace after `?>` is sent as output, can cause "headers already sent" errors
> Fix: Either remove whitespace or (better) don't use closing `?>` tag in PHP-only files

### Logic Errors

**1. Change `!isset($_SESSION['user'])` to `isset($_SESSION['user'])`**
> Bug: Redirects logged-in users to login, lets non-logged-in users access profile
> Problem: Logic is inverted
> Fix: Change back to `!isset($_SESSION['user'])`

**2. Remove `exit` after header redirect**
> Bug: Code continues executing after redirect
> Problem: Protected content might be processed/displayed before redirect happens
> Fix: Always add `exit;` after `header('Location: ...')`

**3. Change `UPLOAD_ERR_OK` to `UPLOAD_ERR_NO_FILE`**
> Bug: Only processes when NO file is uploaded, ignores actual uploads
> Problem: `UPLOAD_ERR_NO_FILE` means no file was selected
> Fix: Check for `UPLOAD_ERR_OK` (value 0) which means successful upload

### Security Issues

**1. Remove `htmlspecialchars()` from username display**
> Bug: `<h2><?= $username ?></h2>`
> Problem: XSS vulnerability - username like `<script>alert('hacked')</script>` would execute
> Fix: Always use `htmlspecialchars($username)`

**2. Use `md5()` instead of `password_hash()`**
> Bug: `'password' => md5($password)`
> Problem: MD5 is fast (easy to brute force), no salt, has rainbow tables
> Fix: Use `password_hash($password, PASSWORD_DEFAULT)` and `password_verify()`

**3. Store password in cookie instead of token**
> Bug: `setcookie('remember', $password, ...)`
> Problem: Password exposed in browser, sent with every request, can be stolen
> Fix: Generate random token: `bin2hex(random_bytes(32))`

---

## Quick Assessment Checklist

| Question Type | Student Response | Score |
|--------------|------------------|-------|
| Can explain session flow | Yes / Partial / No | /10 |
| Understands password hashing | Yes / Partial / No | /10 |
| Can explain file upload process | Yes / Partial / No | /10 |
| Can make live modifications | Yes / Partial / No | /10 |
| Can debug introduced errors | Yes / Partial / No | /10 |

**Total: ___ / 50**

---

## Red Flags to Watch For

- Cannot explain what `password_verify()` does
- Doesn't know why we use `exit` after redirect
- Can't locate where validation happens
- Unable to make simple changes like modifying error messages
- Doesn't understand difference between `$_SESSION` and `$_COOKIE`
- Uses terms like "it just checks" without specifics
- Cannot trace the flow of a form submission
- Unfamiliar with their own variable names
- Can't explain why certain security measures exist
