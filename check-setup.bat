@echo off
echo ========================================
echo Logistics System - Setup Checker
echo ========================================
echo.

echo Checking PHP...
php --version >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] PHP is installed
    php --version | findstr /C:"PHP"
) else (
    echo [MISSING] PHP is not installed
    echo.
    echo Please install PHP from one of these options:
    echo   1. Laragon (Recommended - includes everything): https://laragon.org/download/
    echo   2. XAMPP: https://www.apachefriends.org/download.html
    echo   3. Manual PHP: https://windows.php.net/download/
    echo.
)

echo.
echo Checking Composer...
composer --version >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] Composer is installed
    composer --version
) else (
    echo [MISSING] Composer is not installed
    echo.
    echo Please install Composer from: https://getcomposer.org/download/
    echo Or use Laragon which includes Composer
    echo.
)

echo.
echo ========================================
echo.

if exist vendor (
    echo [OK] Dependencies folder exists
) else (
    echo [INFO] Dependencies not installed yet
    echo        Run: composer install
)

if exist .env (
    echo [OK] .env file exists
) else (
    echo [INFO] .env file not found
    echo        Will be created during setup
)

echo.
echo ========================================
echo NEXT STEPS:
echo ========================================
echo.
echo 1. Install PHP and Composer (see above)
echo 2. Run: setup.bat
echo 3. Or follow instructions in START_HERE.md
echo.
pause


