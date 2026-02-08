# User Profile System

This project is a modern PHP application for user management, fully integrated with Supabase for database and storage.

## Features

-   **Registration & Login**: Secure authentication with password hasing (Bcrypt).
-   **Profile Management**: Update your username, email, and upload profile pictures.
-   **Cloud Integration**:
    -   **Database**: All user data is stored in a **Supabase PostgreSQL** database.
    -   **Storage**: Profile pictures are uploaded to **Supabase Storage** (Buckets).
-   **Security**: Uses `.env` for credentials, secure session handling, and PDO for SQL injection prevention.

## Technology Stack

-   **Backend**: PHP 8.2+
-   **Database**: PostgreSQL (Supabase)
-   **Storage**: Supabase Storage via `guzzlehttp/guzzle`
-   **Frontend**: HTML5, CSS3, PHP (for logic)
-   **Environment**: Docker (Production) or PHP CLI (Development)

## How to Run

### Development (PHP CLI)
Ideal for quick testing and development.
1.  Install dependencies:
    ```bash
    composer install
    ```
2.  Start the server:
    ```bash
    php -S localhost:8080
    ```
3.  Visit [http://localhost:8080](http://localhost:8080)

### Production (Docker)
Ideal for deployment or isolated environments.
1.  Build and run the container:
    ```bash
    docker-compose up --build
    ```
2.  Visit [http://localhost:8080](http://localhost:8080)

## Configuration

The application uses a `.env` file for configuration. Ensure the following keys are set:
-   `SUPABASE_URL`: Your Supabase Project URL.
-   `SUPABASE_KEY`: Your Supabase Anon/Service Key.
-   `DATABASE_URL`: Connection string for PostgreSQL.
