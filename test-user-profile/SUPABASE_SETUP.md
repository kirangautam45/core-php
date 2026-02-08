# Supabase Database Connection Setup

## The Problem
The current `DATABASE_URL` in your `.env` file is not working because:
- Port 5432 (direct connection) is blocked or requires IP whitelisting
- The hostname format might be incorrect

## Solution: Get the Correct Connection String from Supabase

### Step 1: Go to Your Supabase Project Dashboard
1. Open https://supabase.com/dashboard
2. Select your project: `exevuqwyxetlvdtggeyv`

### Step 2: Navigate to Database Settings
1. Click on the **Settings** icon (⚙️) in the left sidebar
2. Click on **Database**

### Step 3: Get the Connection String
1. Scroll down to the **Connection String** section
2. You'll see two tabs:
   - **URI** (recommended)
   - **PSQL**

3. **IMPORTANT**: Enable "Use connection pooling" and select mode **Transaction**
   - This will give you a pooler URL with port **6543** instead of 5432
   - Format will be something like:
     ```
     postgresql://postgres.[PROJECT-REF]:[PASSWORD]@aws-0-[REGION].pooler.supabase.com:6543/postgres
     ```

4. Copy the complete connection string

### Step 4: Check Database Access Settings
1. While in Database settings, scroll to **Connection pooling**
2. Make sure it's **enabled**
3. Check **Network Restrictions** - ensure your IP is allowed, or allow all IPs for testing

### Step 5: Update Your .env File
Replace the `DATABASE_URL` line in your `.env` file with the connection string you copied.

Example:
```
DATABASE_URL=postgresql://postgres.exevuqwyxetlvdtggeyv:[YOUR_PASSWORD]@aws-0-us-east-1.pooler.supabase.com:6543/postgres
```

**Note**: The region (`us-east-1`) and exact format will be shown in your dashboard.

### Step 6: Restart Docker
After updating the .env file:
```bash
docker compose down
docker compose up -d
docker compose exec web php test-connection.php
```

## Alternative: Enable Direct Connection (Not Recommended for Production)
If you must use direct connection (port 5432):
1. In Supabase Dashboard → Settings → Database
2. Scroll to **Connection pooling**
3. Disable "Use connection pooling" to get the direct connection string
4. You may need to whitelist your IP address in the network settings
