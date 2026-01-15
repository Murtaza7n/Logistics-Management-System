# Logistics Management System

A full-featured Logistics Management System built with Laravel 10, MySQL, and Bootstrap 5.

## Features

### 1. User & Role Management
- Roles: Admin, Staff, Driver
- CRUD operations for users
- Role-based access control
- Activity logging

### 2. Employee Management & Payroll
- Employee CRUD operations
- Payroll management with automatic net salary calculation
- Payslip generation
- Monthly payroll reports

### 3. Customer & Vendor Management
- Customer CRUD operations
- Vendor CRUD operations
- Customer and vendor-wise billing reports

### 4. Shipment / Cargo Management
- Manual shipment number entry
- Assign vehicle and driver
- Track shipment status (booked, in-transit, delivered, etc.)
- Daily/Weekly/Monthly reports

### 5. Vehicle & Driver Management
- Vehicle CRUD operations
- Driver CRUD operations
- Vehicle assignment to drivers
- Vehicle usage reports
- Driver performance reports

### 6. Billing & Invoicing
- Auto-generated invoice numbers
- Tax calculation (with/without tax)
- Payment tracking
- Customer and vendor invoices
- Monthly billing reports

### 7. Reports & Dashboard
- Dashboard with key statistics
- Shipment reports
- Revenue reports
- Payroll reports
- Vehicle usage reports
- Driver performance reports
- Customer-wise and vendor-wise reports
- Export to PDF functionality

## Technology Stack

- **Backend**: Laravel 10
- **Database**: MySQL
- **Frontend**: HTML, CSS, Bootstrap 5
- **JavaScript**: jQuery (minimal)
- **PDF Export**: DomPDF
- **Excel Export**: Maatwebsite Excel (ready for implementation)

## Installation

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js and NPM (optional, for asset compilation)

### Steps

1. **Clone or extract the project**
   ```bash
   cd Logistic
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Configure database in `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=logistics_db
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed database with sample data**
   ```bash
   php artisan db:seed
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   - Open browser: `http://localhost:8000`
   - Login with:
     - **Admin**: admin@logistics.com / password
     - **Staff**: staff@logistics.com / password
     - **Driver**: driver@logistics.com / password

## Default Login Credentials

- **Admin User**
  - Email: admin@logistics.com
  - Password: password
  - Role: Admin

- **Staff User**
  - Email: staff@logistics.com
  - Password: password
  - Role: Staff

- **Driver User**
  - Email: driver@logistics.com
  - Password: password
  - Role: Driver

## Color Scheme

- Primary Dark Gray: #4B5563
- Secondary Gray: #6B7280
- Dark Background: #1F2937 (sidebar, navbar)
- Light Background: #F0F4F8 (main content, cards)

## Project Structure

```
Logistic/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # All controllers
│   │   └── Middleware/      # Role middleware
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   └── views/               # Blade templates
│       ├── layouts/         # Layout files
│       ├── auth/            # Authentication views
│       ├── dashboard.blade.php
│       ├── users/          # User management views
│       ├── employees/      # Employee views
│       ├── payrolls/       # Payroll views
│       ├── customers/      # Customer views
│       ├── vendors/        # Vendor views
│       ├── shipments/      # Shipment views
│       ├── vehicles/       # Vehicle views
│       ├── drivers/         # Driver views
│       ├── invoices/       # Invoice views
│       ├── payments/        # Payment views
│       └── reports/        # Report views
├── routes/
│   └── web.php             # Web routes
└── public/                 # Public assets
```

## Key Features Implementation

### Auto-numbering
- **Employee IDs**: Auto-incremented
- **Invoice Numbers**: Format: INV-YYYY-##### (e.g., INV-2024-00001)
- **Shipment Numbers**: Manual entry (as specified)

### Activity Logging
All CRUD operations are logged in the `activity_logs` table with:
- User who performed the action
- Action type (created, updated, deleted)
- Model type and ID
- Description
- Old and new values (JSON)

### Role-Based Access Control
- **Admin**: Full access to all features
- **Staff**: Access to most features except user management
- **Driver**: Limited access (view shipments, vehicles, drivers)

### Reports Export
- PDF export available for all reports
- Excel export ready for implementation (using Maatwebsite Excel)

## Future Integration Points

The codebase is structured to easily integrate:

1. **Mobile App API**
   - Controllers can be extended with API routes
   - Add API authentication (Sanctum is already included)
   - Create API resources for JSON responses

2. **SMS Notifications**
   - Add SMS service in `app/Services/SmsService.php`
   - Integrate with services like Twilio, Nexmo, etc.
   - Add notification triggers in controllers

3. **Email Notifications**
   - Laravel Mail is ready
   - Create notification classes in `app/Notifications/`
   - Configure SMTP in `.env`

4. **Warehouse Management**
   - Add warehouse model and migration
   - Create warehouse controller
   - Link shipments to warehouses

## Development Notes

- All models use proper relationships (hasMany, belongsTo, belongsToMany)
- Controllers include validation and error handling
- Views use Bootstrap 5 with custom color scheme
- Responsive design for mobile devices
- Form validation on both client and server side

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues or questions, please refer to the Laravel documentation or create an issue in the repository.


