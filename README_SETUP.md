# 🚀 Quick Setup Guide for Localhost

## Prerequisites (Install These First)

### 1. PHP 8.1 or Higher
- **Download**: https://windows.php.net/download/
- **Install**: Extract to `C:\php` (or any folder)
- **Add to PATH**: 
  - Search "Environment Variables" in Windows
  - Edit "Path" → Add PHP folder path
  - Restart terminal

### 2. Composer
- **Download**: https://getcomposer.org/Composer-Setup.exe
- **Install**: Run the installer (auto-detects PHP)

### 3. MySQL
- **Download**: https://dev.mysql.com/downloads/installer/
- **Install**: MySQL Server
- **Remember**: Your root password

---

## 🎯 Easiest Setup Method

### Step 1: Run Setup Script
Double-click **`setup.ps1`** (PowerShell) or **`setup.bat`** (Command Prompt)

The script will:
- ✅ Check PHP and Composer
- ✅ Install dependencies
- ✅ Generate app key
- ✅ Guide you through database setup

### Step 2: Create Database
Open MySQL (phpMyAdmin or command line) and run:
```sql
CREATE DATABASE logistics_db;
```

### Step 3: Update .env File
Open `.env` file and set your MySQL password:
```env
DB_PASSWORD=your_mysql_password
```

### Step 4: Complete Setup
Run the setup script again or manually run:
```bash
php artisan migrate
php artisan db:seed
```

### Step 5: Start Server
Double-click **`start-server.bat`** or run:
```bash
php artisan serve
```

### Step 6: Access Application
Open browser: **http://localhost:8000**

**Login Credentials** (after seeding):
- Admin: `admin@logistics.com` / `password`
- Staff: `staff@logistics.com` / `password`
- Driver: `driver@logistics.com` / `password`

---

## 📋 Manual Setup (If Scripts Don't Work)

### 1. Install Dependencies
```bash
composer install
```

### 2. Generate App Key
```bash
php artisan key:generate
```

### 3. Create Database
```sql
CREATE DATABASE logistics_db;
```

### 4. Update .env
Edit `.env` file:
```env
DB_DATABASE=logistics_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Seed Database (Optional)
```bash
php artisan db:seed
```

### 7. Start Server
```bash
php artisan serve
```

---

## ❗ Troubleshooting

### "php is not recognized"
- PHP not in PATH
- Add PHP folder to Windows PATH
- Restart terminal/command prompt

### "composer is not recognized"
- Install Composer from https://getcomposer.org/download/
- Or use: `php composer.phar install`

### Database Connection Error
- Check MySQL is running
- Verify database name: `logistics_db`
- Check username/password in `.env`

### Port 8000 Already in Use
```bash
php artisan serve --port=8001
```

---

## 📚 More Help

- **Detailed Guide**: See `DEPLOYMENT.md`
- **Quick Reference**: See `QUICK_START.md`

---

## ✅ Success Checklist

- [ ] PHP 8.1+ installed and in PATH
- [ ] Composer installed
- [ ] MySQL installed and running
- [ ] Database `logistics_db` created
- [ ] `.env` file configured
- [ ] Dependencies installed (`composer install`)
- [ ] Migrations run (`php artisan migrate`)
- [ ] Database seeded (`php artisan db:seed`)
- [ ] Server started (`php artisan serve`)
- [ ] Application accessible at http://localhost:8000

---

**Need help?** Check the error messages and refer to the troubleshooting section above.

