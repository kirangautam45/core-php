# Database Setup Guide

This guide will help you set up MySQL databases for the PHP practice exercises.

---

## Quick Info

| Setting | Value |
|---------|-------|
| **Username** | `test` |
| **Password** | `test` |
| **Databases** | day17_practice, day18_practice, day19_practice, day20_practice |

---

## Method 1: Using phpMyAdmin (Easiest)

This is the recommended method for beginners.

### Step 1: Open phpMyAdmin

Open your browser and go to:

| Software | URL |
|----------|-----|
| XAMPP | http://localhost/phpmyadmin |
| MAMP | http://localhost:8888/phpmyadmin |
| WAMP | http://localhost/phpmyadmin |

### Step 2: Run the SQL Script

1. Click on the **"SQL"** tab at the top
2. Open the file `setup_all_databases.sql` in a text editor
3. Copy ALL the SQL code (starting from `CREATE USER`)
4. Paste into the SQL text box in phpMyAdmin
5. Click the **"Go"** button

### Step 3: Verify

You should see success messages. Check the left sidebar - you should see:
- day17_practice
- day18_practice
- day19_practice
- day20_practice

---

## Method 2: Mac Terminal

### Step 1: Open Terminal

Press `Cmd + Space`, type "Terminal", press Enter

### Step 2: Navigate to Project Folder

```bash
cd /path/to/your/days
```

### Step 3: Run the Script

Choose ONE option based on your setup:

**Option A - MySQL root has NO password:**
```bash
mysql -u root < setup_all_databases.sql
```

**Option B - MySQL root HAS a password:**
```bash
mysql -u root -p < setup_all_databases.sql
```
Enter your root password when prompted.

**Option C - Using MAMP:**
```bash
/Applications/MAMP/Library/bin/mysql -u root -p < setup_all_databases.sql
```

**Option D - Using Homebrew MySQL:**
```bash
/opt/homebrew/bin/mysql -u root -p < setup_all_databases.sql
```

### Step 4: Verify

```bash
mysql -u test -ptest -e "SHOW DATABASES;"
```

---

## Method 3: Windows Command Prompt

### Step 1: Open Command Prompt as Administrator

1. Press the **Windows key**
2. Type "cmd"
3. Right-click on "Command Prompt"
4. Select **"Run as administrator"**

### Step 2: Navigate to MySQL bin Folder

Choose based on your setup:

**For XAMPP:**
```cmd
cd C:\xampp\mysql\bin
```

**For WAMP:**
```cmd
cd C:\wamp64\bin\mysql\mysql8.0.31\bin
```
(Note: version number may differ)

**For MySQL Installer:**
```cmd
cd "C:\Program Files\MySQL\MySQL Server 8.0\bin"
```

### Step 3: Run the Script

Choose ONE option:

**Option A - MySQL root has NO password:**
```cmd
mysql -u root < "C:\path\to\your\days\setup_all_databases.sql"
```

**Option B - MySQL root HAS a password:**
```cmd
mysql -u root -p < "C:\path\to\your\days\setup_all_databases.sql"
```
Enter your root password when prompted.

**Option C - Copy-Paste Method:**
1. Open MySQL command line:
   ```cmd
   mysql -u root -p
   ```
2. Open `setup_all_databases.sql` in Notepad
3. Copy all the SQL code
4. Right-click in the command prompt to paste
5. Press Enter

### Step 4: Verify

```cmd
mysql -u test -ptest -e "SHOW DATABASES;"
```

---

## What Gets Created

### Databases and Tables

| Database | Tables | Description |
|----------|--------|-------------|
| day17_practice | users (5 records) | Basic CRUD operations |
| day18_practice | users (3), products (3) | Forms and validation |
| day19_practice | contacts, users | Contact form and registration |
| day20_practice | users (30), products (25), categories (5), orders (15) | Full e-commerce practice |

### User Account

```
Username: test
Password: test
Host: localhost
```

This user has full access to all practice databases.

---

## Troubleshooting

### Error: "Access denied for user 'root'"

- Make sure MySQL is running
- Check your root password is correct
- Try without password: `mysql -u root` (if no password is set)

### Error: "'mysql' is not recognized" (Windows)

- You need to navigate to the MySQL bin folder first
- Or add MySQL to your system PATH:
  1. Search "Environment Variables" in Windows
  2. Edit PATH variable
  3. Add `C:\xampp\mysql\bin` (or your MySQL bin path)

### Error: "command not found: mysql" (Mac)

- Install MySQL via Homebrew: `brew install mysql`
- Or check if MAMP/XAMPP is installed correctly
- Make sure MySQL service is running

### Error: "User 'test' already exists"

- This is OK! The script uses `IF NOT EXISTS` so it will continue

### Error: "Database already exists"

- This is OK! The script will just use the existing database

### Error: "Table already exists"

- This is OK! The script uses `IF NOT EXISTS` for tables

---

## Testing Your Connection

Create a test file `test_connection.php`:

```php
<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=day20_practice;charset=utf8mb4",
        "test",
        "test"
    );
    echo "Connected successfully!";

    // Test query
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "\nUsers in database: " . $result['count'];

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
```

Run it:
```bash
php test_connection.php
```

Expected output:
```
Connected successfully!
Users in database: 30
```

---

## Method 4: Windows with PHP CLI (Without XAMPP/WAMP)

For those who prefer a lightweight setup without installing XAMPP, WAMP, or similar tools.

### Step 1: Install PHP

**Option A - Download PHP directly:**
1. Go to [https://windows.php.net/download/](https://windows.php.net/download/)
2. Download the **VS16 x64 Thread Safe** zip file (recommended)
3. Extract to `C:\php`
4. Rename `php.ini-development` to `php.ini`

**Option B - Using Chocolatey (Package Manager):**
```cmd
choco install php
```

**Option C - Using Scoop:**
```powershell
scoop install php
```

### Step 2: Add PHP to System PATH

1. Press `Windows + S`, search **"Environment Variables"**
2. Click **"Edit the system environment variables"**
3. Click **"Environment Variables"** button
4. Under "System variables", find and select **"Path"**
5. Click **"Edit"** → **"New"**
6. Add `C:\php` (or your PHP installation path)
7. Click **"OK"** on all windows

### Step 3: Enable Required PHP Extensions

Open `C:\php\php.ini` in a text editor and uncomment these lines (remove the `;`):

```ini
extension=mysqli
extension=pdo_mysql
extension=mbstring
extension=openssl
```

### Step 4: Verify PHP Installation

Open a **new** Command Prompt and run:
```cmd
php -v
```

You should see PHP version info.

### Step 5: Install MySQL (Standalone)

**Option A - MySQL Installer:**
1. Download from [https://dev.mysql.com/downloads/mysql/](https://dev.mysql.com/downloads/mysql/)
2. Choose **"MySQL Installer for Windows"**
3. Run installer and select **"MySQL Server"** only
4. Follow setup wizard, set a root password

**Option B - Using Chocolatey:**
```cmd
choco install mysql
```

**Option C - Using Scoop:**
```powershell
scoop install mysql
```

### Step 6: Start MySQL Service

```cmd
# Start MySQL service
net start mysql

# Or if using MySQL 8+
net start mysql80
```

### Step 7: Run the Database Setup Script

```cmd
# Navigate to your project folder
cd C:\path\to\your\days

# Run the SQL script
mysql -u root -p < setup_all_databases.sql
```

### Step 8: Run PHP Files

Now you can run PHP files directly from command line:

```cmd
# Navigate to your project
cd C:\path\to\corephp\days\day-17

# Run a PHP file
php index.php

# Or use PHP's built-in server
php -S localhost:8000
```

Then open `http://localhost:8000` in your browser.

### Quick Commands Reference

| Command | Description |
|---------|-------------|
| `php -v` | Check PHP version |
| `php -m` | List installed modules |
| `php -S localhost:8000` | Start built-in web server |
| `php filename.php` | Run a PHP file |
| `php -i` | Show PHP configuration |
| `net start mysql` | Start MySQL service |
| `net stop mysql` | Stop MySQL service |

### Useful Tips for Windows CLI Users

**Create a batch file for quick server start:**

Create `start-server.bat` in your project folder:
```batch
@echo off
echo Starting PHP server at http://localhost:8000
echo Press Ctrl+C to stop
php -S localhost:8000
```

**Add MySQL to PATH:**
Add `C:\Program Files\MySQL\MySQL Server 8.0\bin` to your PATH (same process as PHP).

**Check if services are running:**
```cmd
sc query mysql
```

---

---

## Method 5: Mac with PHP CLI (Without XAMPP/MAMP) - Homebrew

For Mac users who prefer a lightweight setup using Homebrew.

### Step 1: Install Homebrew (if not installed)

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

### Step 2: Install PHP

```bash
brew install php
```

### Step 3: Install MySQL

```bash
brew install mysql
```

### Step 4: Start MySQL Service

```bash
brew services start mysql
```

### Step 5: Initialize MySQL with `data`/`data` User

By default, Homebrew MySQL has no root password. Run these commands:

```bash
# Connect as root (no password needed initially)
mysql -u root

# Then run these SQL commands:
CREATE USER 'data'@'localhost' IDENTIFIED BY 'data';
GRANT ALL PRIVILEGES ON *.* TO 'data'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
exit;
```

### Step 6: Run the Database Setup Script

```bash
cd /path/to/your/days
mysql -u data -pdata < setup_all_databases.sql
```

### Step 7: Verify

```bash
mysql -u data -pdata -e "SHOW DATABASES;"
```

### Step 8: Run PHP Files

```bash
# Navigate to your project
cd /path/to/corephp/days/day-17

# Run a PHP file
php index.php

# Or use PHP's built-in server
php -S localhost:8000
```

Then open `http://localhost:8000` in your browser.

### Quick Commands Reference (Mac)

| Command | Description |
|---------|-------------|
| `php -v` | Check PHP version |
| `php -m` | List installed modules |
| `php -S localhost:8000` | Start built-in web server |
| `php filename.php` | Run a PHP file |
| `brew services start mysql` | Start MySQL service |
| `brew services stop mysql` | Stop MySQL service |
| `brew services list` | Check service status |

### Useful Tips for Mac CLI Users

**Create a shell script for quick server start:**

Create `start-server.sh` in your project folder:
```bash
#!/bin/bash
echo "Starting PHP server at http://localhost:8000"
echo "Press Ctrl+C to stop"
php -S localhost:8000
```

Make it executable:
```bash
chmod +x start-server.sh
```

**Reset MySQL if you forgot the password:**
```bash
brew services stop mysql
rm -rf /opt/homebrew/var/mysql
mysqld --initialize-insecure --user=$(whoami) --datadir=/opt/homebrew/var/mysql
brew services start mysql
```

---

## Method 6: Windows with PHP CLI - Fresh MySQL Setup with `data`/`data`

For Windows users who want to set up MySQL from scratch with `data`/`data` credentials.

### Step 1: Install PHP (if not installed)

1. Download from [https://windows.php.net/download/](https://windows.php.net/download/)
2. Download **VS16 x64 Thread Safe** zip
3. Extract to `C:\php`
4. Rename `php.ini-development` to `php.ini`
5. Enable extensions in `php.ini`:
   ```ini
   extension=mysqli
   extension=pdo_mysql
   extension=mbstring
   extension=openssl
   ```
6. Add `C:\php` to System PATH

### Step 2: Install MySQL

1. Download from [https://dev.mysql.com/downloads/mysql/](https://dev.mysql.com/downloads/mysql/)
2. Choose **MySQL Installer for Windows**
3. During setup, when asked for root password, set it to `data` (or remember what you set)

### Step 3: Start MySQL Service

```cmd
net start mysql80
```

### Step 4: Create `data`/`data` User

Open Command Prompt and run:

```cmd
mysql -u root -p
```

Enter your root password, then run:

```sql
CREATE USER 'data'@'localhost' IDENTIFIED BY 'data';
GRANT ALL PRIVILEGES ON *.* TO 'data'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;
exit;
```

### Step 5: Run the Database Setup Script

```cmd
cd C:\path\to\your\days
mysql -u data -pdata < setup_all_databases.sql
```

### Step 6: Verify

```cmd
mysql -u data -pdata -e "SHOW DATABASES;"
```

### Step 7: Run PHP Files

```cmd
cd C:\path\to\corephp\days\day-17
php -S localhost:8000
```

Open `http://localhost:8000` in your browser.

### Reset MySQL Password on Windows (if forgotten)

1. Stop MySQL:
   ```cmd
   net stop mysql80
   ```

2. Start MySQL in safe mode:
   ```cmd
   mysqld --skip-grant-tables --shared-memory
   ```

3. Open another Command Prompt:
   ```cmd
   mysql -u root
   ```

4. Reset password:
   ```sql
   FLUSH PRIVILEGES;
   ALTER USER 'root'@'localhost' IDENTIFIED BY 'data';
   CREATE USER IF NOT EXISTS 'data'@'localhost' IDENTIFIED BY 'data';
   GRANT ALL PRIVILEGES ON *.* TO 'data'@'localhost' WITH GRANT OPTION;
   FLUSH PRIVILEGES;
   exit;
   ```

5. Stop safe mode (Ctrl+C) and restart normally:
   ```cmd
   net start mysql80
   ```

---

## User Credentials Summary

| User | Password | Access |
|------|----------|--------|
| `data` | `data` | Full admin access (all databases) |
| `test` | `test` | Practice databases only |

Use `data`/`data` for admin tasks, `test`/`test` for practice exercises.

---

## Need Help?

If you're still having issues:

1. Make sure MySQL/MariaDB service is running
2. Check that you're using the correct port (usually 3306)
3. Verify XAMPP/MAMP/WAMP control panel shows MySQL as "Running"
4. Try restarting the MySQL service
