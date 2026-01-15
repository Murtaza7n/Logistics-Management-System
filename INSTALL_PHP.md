# Install PHP, Composer & MySQL - Quick Guide

## ⚡ Fastest Way to Get Started

### Option 1: Use Laragon (Recommended - All-in-One)
**Laragon includes PHP, MySQL, and more!**

1. **Download Laragon**: https://laragon.org/download/
2. **Install** (includes PHP 8.1+, MySQL, Composer)
3. **Start Laragon**
4. **Open Terminal in Laragon**
5. Navigate to project: `cd C:\Users\Murtaza Lapi\Desktop\Logistic`
6. Run: `composer install`
7. Run: `php artisan key:generate`
8. Create database in Laragon MySQL
9. Run: `php artisan migrate`
10. Run: `php artisan db:seed`
11. Run: `php artisan serve`

### Option 2: Use XAMPP (Popular Choice)

1. **Download XAMPP**: https://www.apachefriends.org/download.html
2. **Install** (includes PHP, MySQL)
3. **Add PHP to PATH**:
   - Usually: `C:\xampp\php`
   - Add to Windows Environment Variables → Path
4. **Install Composer**: https://getcomposer.org/Composer-Setup.exe
5. Restart terminal
6. Run setup commands

### Option 3: Manual PHP Installation

1. **Download PHP**: https://windows.php.net/download/
   - Choose: PHP 8.1+ Thread Safe ZIP
   - Extract to: `C:\php`
2. **Add to PATH**:
   - Search "Environment Variables"
   - Edit "Path" → Add `C:\php`
3. **Install Composer**: https://getcomposer.org/Composer-Setup.exe
4. **Install MySQL**: https://dev.mysql.com/downloads/installer/
5. Restart terminal
6. Run setup commands

---

## 🚀 After Installation - Run These Commands

```bash
# Navigate to project
cd "C:\Users\Murtaza Lapi\Desktop\Logistic"

# Install dependencies
composer install

# Generate app key
php artisan key:generate

# Create database in MySQL (run in MySQL):
# CREATE DATABASE logistics_db;

# Update .env file with MySQL password

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start server
php artisan serve
```

Then open: **http://localhost:8000**

---

## ✅ Verify Installation

After installing, verify in terminal:

```bash
php --version    # Should show PHP 8.1+
composer --version  # Should show Composer version
mysql --version  # Should show MySQL version
```

---

## 🎯 Recommended: Laragon

**Laragon is the easiest option** - it includes everything you need:
- ✅ PHP (multiple versions)
- ✅ MySQL
- ✅ Composer
- ✅ Easy database management
- ✅ One-click start/stop

Download: https://laragon.org/download/


