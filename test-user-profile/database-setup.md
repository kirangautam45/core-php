# Supabase Database & Storage Setup Guide

Follow this guide to set up your backend infrastructure on Supabase for the User Profile application.

## 1. Create a Supabase Project
1.  Go to [Supabase Dashboard](https://supabase.com/dashboard) and log in.
2.  Click **"New Project"**.
3.  Choose your **Organization**.
4.  Enter a **Name** (e.g., `user-profile`).
5.  Enter a strong **Database Password**.
    - **IMPORTANT:** Save this password immediately! You cannot view it again.
6.  Select a **Region** close to you.
7.  Click **"Create new project"**.
    - *Wait approx. 1-2 minutes for the project to provision.*

## 2. Get API Keys & URL
1.  In your project dashboard, go to **Settings** (Gear icon at the bottom left) -> **API**.
2.  Copy the **Project URL**.
3.  Copy the **`anon` / `public`** Key.
4.  Paste these into your `.env` file:
    ```bash
    SUPABASE_URL=your-project-url
    SUPABASE_KEY=your-anon-key
    ```

## 3. Get Database Connection String
1.  Go to **Settings** -> **Database**.
2.  Under **Connection string**, select the **URI** tab.
3.  Ensure **"Use connection pooling"** is checked (Mode: Transaction).
4.  Copy the connection string.
5.  Paste it into your `.env` file:
    ```bash
    DATABASE_URL=postgresql://postgres.your-ref:[YOUR-PASSWORD]@aws-0-region.pooler.supabase.com:6543/postgres
    ```
6.  **Replace `[YOUR-PASSWORD]`** with the password you created in Step 1.

## 4. Create the `users` Table
1.  Go to the **SQL Editor** (Bash icon on the left sidebar).
2.  Click **"New Query"**.
3.  Paste the following SQL commands:

    ```sql
    -- Create the users table
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

4.  Click **"Run"** (bottom right).
5.  You should see "Success" in the results pane.

## 5. Configure Storage (For Profile Pictures)
1.  Go to **Storage** (Bucket icon on the left sidebar).
2.  Click **"New Bucket"**.
3.  Enter the name: `avatars`.
4.  **TOGGLE ON "Public bucket"**.
    - *If this is not public, images will not load for users.*
5.  Click **"Save"**.

## 6. Verify Configuration
1.  Ensure your `.env` file is saved with the correct values.
2.  Rebuild your local environment:
    ```bash
    docker-compose down
    docker-compose up --build
    ```
3.  Go to `http://localhost:8080/register.php` and try to create a user.
