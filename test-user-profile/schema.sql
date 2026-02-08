-- Run this in your Supabase SQL Editor

-- 1. Create Users Table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username TEXT UNIQUE NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    profile_pic TEXT,
    remember_token TEXT,
    created_at TIMESTAMP DEFAULT NOW()
);

-- 2. Setup Row Level Security (RLS) if needed
-- For this simple app, we are using a direct DB connection which behaves like a service role if not careful, 
-- but effectively we are bypassing RLS by connecting directly via PDO with postgres user.
-- If you were using Supabase JS Client, you would need policies.

-- 3. Storage
-- Go to Storage > Create new bucket named 'avatars'
-- Set it to "Public"
