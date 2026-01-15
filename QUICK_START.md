# Quick Start Guide - Localhost Deployment

## Prerequisites Installation

### 1. Install PHP 8.1 or Higher
- Download from: https://windows.php.net/download/
- Extract to `C:\php` (or any directory)
- Add PHP to PATH:
  - Right-click "This PC" → Properties → Advanced System Settings
  - Click "Environment Variables"
  - Under "System Variables", find "Path" and click "Edit"
  - Click "New" and add: `C:\php` (or your PHP directory)
  - Click OK on all dialogs

### 2. Install Composer
- Download from: https://getcomposer.org/Composer-Setup.exe
- Run the installer (it will auto-detect PHP)
- Or download `composer.phar` and place it in project folder

### 3. Install MySQL
- Download from: https://dev.mysql.com/downloads/installer/
- Install MySQL Server
- Remember your root password

## Quick Setup (3 Steps)

### Option A: Using Setup Script (Recommended)

1. **Double-click `setup.bat`**
   - This will guide you through the entire setup process

2. **Create Database in MySQL:**
   ```sql
   CREATE DATABASE logistics_db;
   ```

3. **Update `.env` file:**
   - Open `.env` in a text editor
   - Set your MySQL password:
     ```
     DB_PASSWORD=your_mysql_password
     ```

4. **Run setup.bat again** to complete migrations

### Option B: Manual Setup

1. **Install Dependencies:**
   ```bash
   composer install
   ```

2. **Generate App Key:**
   ```bash
   php artisan key:generate
   ```

3. **Create Database:**
   - Open MySQL (phpMyAdmin or command line)
   - Run: `CREATE DATABASE logistics_db;`

4. **Update `.env` file:**
   - Set `DB_PASSWORD=your_mysql_password`

5. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

6. **Seed Database (Optional):**
   ```bash
   php artisan db:seed
   ```

## Start the Server

### Option 1: Using Batch File
- Double-click `start-server.bat`

### Option 2: Using Command Line
```bash
php artisan serve
```

## Access the Application

- Open browser: **http://localhost:8000**
- Login with:
  - **Admin**: admin@logistics.com / password
  - **Staff**: staff@logistics.com / password
  - **Driver**: driver@logistics.com / password

## Troubleshooting

### "php is not recognized"
- PHP is not in PATH
- Add PHP directory to Windows PATH (see Prerequisites)

### "composer is not recognized"
- Composer is not installed or not in PATH
- Install Composer or use `php composer.phar` instead

### Database Connection Error
- Check MySQL is running
- Verify database name in `.env`
- Check username/password in `.env`

### Port 8000 Already in Use
```bash
php artisan serve --port=8001
```

## Need Help?

Check `DEPLOYMENT.md` for detailed instructions.


