@echo off
echo ========================================
echo Logistics Management System - Setup
echo ========================================
echo.

echo Step 1: Checking PHP...
php --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: PHP is not installed or not in PATH
    echo Please install PHP 8.1+ from https://windows.php.net/download/
    echo.
    pause
    exit /b 1
)
echo PHP found!
echo.

echo Step 2: Checking Composer...
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: Composer is not installed or not in PATH
    echo Please install Composer from https://getcomposer.org/download/
    echo.
    pause
    exit /b 1
)
echo Composer found!
echo.

echo Step 3: Installing dependencies...
composer install
if %errorlevel% neq 0 (
    echo ERROR: Failed to install dependencies
    pause
    exit /b 1
)
echo Dependencies installed!
echo.

echo Step 4: Generating application key...
php artisan key:generate
if %errorlevel% neq 0 (
    echo ERROR: Failed to generate application key
    pause
    exit /b 1
)
echo Application key generated!
echo.

echo Step 5: Database Setup
echo.
echo IMPORTANT: Before proceeding, please:
echo 1. Create a MySQL database named 'logistics_db'
echo 2. Update .env file with your database credentials
echo.
set /p continue="Have you created the database and updated .env? (y/n): "
if /i not "%continue%"=="y" (
    echo Please create the database and update .env file, then run this script again.
    pause
    exit /b 0
)

echo.
echo Step 6: Running migrations...
php artisan migrate
if %errorlevel% neq 0 (
    echo ERROR: Failed to run migrations
    echo Please check your database connection in .env file
    pause
    exit /b 1
)
echo Migrations completed!
echo.

echo Step 7: Seeding database with sample data...
set /p seed="Do you want to seed the database with sample data? (y/n): "
if /i "%seed%"=="y" (
    php artisan db:seed
    if %errorlevel% neq 0 (
        echo WARNING: Failed to seed database
    ) else (
        echo Database seeded successfully!
        echo.
        echo Default login credentials:
        echo Admin: admin@logistics.com / password
        echo Staff: staff@logistics.com / password
        echo Driver: driver@logistics.com / password
    )
)
echo.

echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo To start the server, run:
echo   php artisan serve
echo.
echo Then open: http://localhost:8000
echo.
pause


