# Career Roadmap SaaS - MVP Baseline

This folder contains the complete starter code for your Core PHP SaaS. It follows the exact plan discussed earlier.

## 📁 What's Included:
1. `database.sql`: The entire SQL schema for your database.
2. `htdocs/`: The core web folder containing:
   * **Authentication System**: `register.php`, `login.php`, `logout.php` (with secure password hashing and XSS protection built-in).
   * **Dashboard**: `dashboard.php` (responsive Bootstrap 5 design fetching dynamic data from DB).
   * **Landing Page**: `index.php` (beautiful responsive entrance).
   * **Core Config**: `config/database.php` (PDO DB Connection) and `core/functions.php` (auth checker and sanitization).

---

## 🚀 How to deploy to InfinityFree RIGHT NOW:

### Step 1: Create Database on InfinityFree
1. Go to your InfinityFree control panel.
2. Under "Databases", click **MySQL Databases**.
3. Create a new database (e.g., `roadmap_saas`).
4. Note down the **hostname**, **database name**, **username**, and **password**.

### Step 2: Import SQL
1. Open **phpMyAdmin** from your InfinityFree panel.
2. Select your newly created database on the left sidebar.
3. Click the **"Import"** tab at the top.
4. Upload the `database.sql` file from this folder.
5. Click **"Go"** to create all tables.

### Step 3: Update `database.php`
1. Open `htdocs/config/database.php` in a code editor.
2. Replace these variables with your InfinityFree details:
   ```php
   $host = 'REMOTE_HOST_FROM_CPanel'; // e.g., sql123.infinityfree.com
   $dbname = 'YOUR_DB_NAME';
   $user = 'YOUR_DB_USER';
   $pass = 'YOUR_DB_PASSWORD';
   ```

### Step 4: Upload your Website
1. Open the **"Online File Manager"** or connect via FileZilla FTP.
2. Go inside the `htdocs` folder on the InfinityFree server.
3. **Delete everything** inside it (like `index2.html`).
4. **Upload all the contents** of our local `htdocs/` folder straight into the live `htdocs/` folder.
   *(Make sure `index.php`, `login.php` etc. sit exactly inside the live server's `htdocs/` directory, don't nest them manually further).*

### Step 5: Start Coding The Next Pages!
Your Auth and Dashboard are DONE. Next, you just need to create `applications.php`, `scholarships.php` exactly like we built `dashboard.php`.

Enjoy your new Startup! 🔥
