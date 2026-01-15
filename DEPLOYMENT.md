# Localhost Deployment Guide

## Prerequisites

Before deploying, ensure you have:
1. **PHP 8.1 or higher** installed
2. **Composer** installed and in your PATH
3. **MySQL** server running
4. **Web server** (Apache/Nginx) OR use Laravel's built-in server

## Step-by-Step Deployment

### Step 1: Install Composer Dependencies

```bash
composer install
```

If composer is not installed, download it from: https://getcomposer.org/download/

### Step 2: Generate Application Key

```bash
php artisan key:generate
```

### Step 3: Configure Database

1. Open `.env` file
2. Update database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=logistics_db
   DB_USERNAME=root
   DB_PASSWORD=your_mysql_password
   ```

3. Create the database in MySQL:
   ```sql
   CREATE DATABASE logistics_db;
   ```

### Step 4: Run Migrations

```bash
php artisan migrate
```

### Step 5: Seed Database (Optional - for sample data)

```bash
php artisan db:seed
```

This will create:
- Admin user: admin@logistics.com / password
- Staff user: staff@logistics.com / password
- Driver user: driver@logistics.com / password
- Sample employees, customers, vendors, vehicles, drivers, and shipments

### Step 6: Start Development Server

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

## Quick Setup Script (Windows PowerShell)

Run this in PowerShell from the project directory:

```powershell
# Install dependencies
composer install

# Generate app key
php artisan key:generate

# Create database (adjust credentials as needed)
# You need to do this manually in MySQL or phpMyAdmin

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Start server
php artisan serve
```

## Troubleshooting

### Composer not found
- Download Composer from https://getcomposer.org/download/
- Or use: `php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"`
- Then: `php composer-setup.php`

### Database connection error
- Ensure MySQL is running
- Check database credentials in `.env`
- Verify database exists: `CREATE DATABASE logistics_db;`

### Permission errors
- On Windows, usually not an issue
- On Linux/Mac, may need: `chmod -R 775 storage bootstrap/cache`

### Port 8000 already in use
- Use different port: `php artisan serve --port=8001`

## Default Login Credentials

After seeding:
- **Admin**: admin@logistics.com / password
- **Staff**: staff@logistics.com / password  
- **Driver**: driver@logistics.com / password

## Next Steps

1. Access http://localhost:8000
2. Login with admin credentials
3. Explore the dashboard and features
4. Start managing your logistics operations!


