# Logistics Management System - Setup Script
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Logistics Management System - Setup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check PHP
Write-Host "Step 1: Checking PHP..." -ForegroundColor Yellow
try {
    $phpVersion = php --version 2>&1
    Write-Host "PHP found: $($phpVersion[0])" -ForegroundColor Green
} catch {
    Write-Host "ERROR: PHP is not installed or not in PATH" -ForegroundColor Red
    Write-Host "Please install PHP 8.1+ from https://windows.php.net/download/" -ForegroundColor Yellow
    Write-Host "Add PHP to your PATH environment variable" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

# Check Composer
Write-Host ""
Write-Host "Step 2: Checking Composer..." -ForegroundColor Yellow
try {
    $composerVersion = composer --version 2>&1
    Write-Host "Composer found: $($composerVersion[0])" -ForegroundColor Green
} catch {
    Write-Host "ERROR: Composer is not installed or not in PATH" -ForegroundColor Red
    Write-Host "Please install Composer from https://getcomposer.org/download/" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

# Create .env file if it doesn't exist
Write-Host ""
Write-Host "Step 3: Checking .env file..." -ForegroundColor Yellow
if (-not (Test-Path .env)) {
    if (Test-Path .env.example) {
        Copy-Item .env.example .env
        Write-Host ".env file created from .env.example" -ForegroundColor Green
    } else {
        # Create basic .env file
        @"
APP_NAME="Logistics Management System"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=logistics_db
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
SESSION_LIFETIME=120
"@ | Out-File -FilePath .env -Encoding UTF8
        Write-Host ".env file created" -ForegroundColor Green
    }
} else {
    Write-Host ".env file already exists" -ForegroundColor Green
}

# Install dependencies
Write-Host ""
Write-Host "Step 4: Installing dependencies..." -ForegroundColor Yellow
composer install --no-interaction
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Failed to install dependencies" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}
Write-Host "Dependencies installed successfully!" -ForegroundColor Green

# Generate app key
Write-Host ""
Write-Host "Step 5: Generating application key..." -ForegroundColor Yellow
php artisan key:generate
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Failed to generate application key" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}
Write-Host "Application key generated!" -ForegroundColor Green

# Database setup reminder
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Database Setup Required" -ForegroundColor Yellow
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Before running migrations, please:" -ForegroundColor Yellow
Write-Host "1. Create MySQL database: CREATE DATABASE logistics_db;" -ForegroundColor White
Write-Host "2. Update .env file with your MySQL password:" -ForegroundColor White
Write-Host "   DB_PASSWORD=your_mysql_password" -ForegroundColor White
Write-Host ""
$continue = Read-Host "Have you created the database and updated .env? (y/n)"
if ($continue -ne "y" -and $continue -ne "Y") {
    Write-Host ""
    Write-Host "Please create the database and update .env, then run:" -ForegroundColor Yellow
    Write-Host "  php artisan migrate" -ForegroundColor White
    Write-Host "  php artisan db:seed" -ForegroundColor White
    Read-Host "Press Enter to exit"
    exit 0
}

# Run migrations
Write-Host ""
Write-Host "Step 6: Running migrations..." -ForegroundColor Yellow
php artisan migrate
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Failed to run migrations" -ForegroundColor Red
    Write-Host "Please check your database connection in .env file" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}
Write-Host "Migrations completed successfully!" -ForegroundColor Green

# Seed database
Write-Host ""
$seed = Read-Host "Do you want to seed the database with sample data? (y/n)"
if ($seed -eq "y" -or $seed -eq "Y") {
    Write-Host "Seeding database..." -ForegroundColor Yellow
    php artisan db:seed
    if ($LASTEXITCODE -eq 0) {
        Write-Host "Database seeded successfully!" -ForegroundColor Green
        Write-Host ""
        Write-Host "Default login credentials:" -ForegroundColor Cyan
        Write-Host "  Admin: admin@logistics.com / password" -ForegroundColor White
        Write-Host "  Staff: staff@logistics.com / password" -ForegroundColor White
        Write-Host "  Driver: driver@logistics.com / password" -ForegroundColor White
    }
}

# Complete
Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Setup Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "To start the server, run:" -ForegroundColor Yellow
Write-Host "  php artisan serve" -ForegroundColor White
Write-Host ""
Write-Host "Or double-click: start-server.bat" -ForegroundColor White
Write-Host ""
Write-Host "Then open: http://localhost:8000" -ForegroundColor Cyan
Write-Host ""
Read-Host "Press Enter to exit"


