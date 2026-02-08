# Project Setup & Installation Guide

This guide covers how to set up the **User Profile System** for both **XAMPP** and **PHP CLI** environments.

## 1. Prerequisites (For Everyone)

Before starting, ensure you have the following installed:
-   **PHP 8.2+**
-   **Composer** (Dependency Manager) -> [Download Here](https://getcomposer.org/download/)
-   **Supabase Account** (for Database & Storage)

### Required PHP Extensions
Ensure these lines are uncommented (enabled) in your `php.ini` file:
```ini
extension=curl
extension=mbstring
extension=openssl
extension=pdo_pgsql
extension=pgsql
```

---

## 2. Install Dependencies

Open your terminal (Command Prompt, PowerShell, or Terminal), navigate to the project folder, and run:

```bash
composer install
```
*This installs the required libraries (phpdotenv for credentials, Guzzle for file uploads).*

---

## 3. Configuration (.env)

1.  Create a file named `.env` in the project root.
2.  Add your Supabase credentials (get these from your Supabase Dashboard):

```ini
# Project Settings -> API
SUPABASE_URL=https://your-project.supabase.co
SUPABASE_KEY=your-anon-key

# Project Settings -> Database -> Connection String (URI, Transaction Mode)
DATABASE_URL=postgresql://postgres.yourproject:password@aws-0-region.pooler.supabase.com:6543/postgres
```

---

## 4. Running the Project

### Option A: Using PHP CLI (Simplest)
*Recommended for quick development.*

1.  Open your terminal in the project folder.
2.  Run the built-in server:
    ```bash
    php -S localhost:8080
    ```
3.  Open your browser to: **http://localhost:8080**

### Option B: Using XAMPP
*Recommended if you are already using Apache.*

1.  **Move the Folder**: Copy the entire `test-user-profile` folder into your XAMPP `htdocs` directory (usually `C:\xampp\htdocs\` or `/Applications/XAMPP/htdocs/`).
2.  **Enable PostgreSQL in XAMPP**:
    -   Open XAMPP Control Panel -> Config -> PHP (php.ini).
    -   Search for `extension=pdo_pgsql` and remove the semicolon `;` at the start of the line.
    -   Save and **Restart Apache**.
3.  **Access the Site**:
    -   Open your browser to: **http://localhost/test-user-profile/**

---

## 5. Troubleshooting

-   **"Class 'SupabaseStorage' not found"**: You forgot to run `composer install`.
-   **"Call to undefined function pg_connect()" or PDO Driver not found**: You didn't enable `pdo_pgsql` in your `php.ini`. Restart Apache/PHP after changing `php.ini`.
-   **"Network is unreachable" (Docker)**: Restart Docker Desktop.
