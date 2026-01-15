<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // User Management (Admin & Staff only)
    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Employee Management (Admin & Staff only)
    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('employees', EmployeeController::class);
    });

    // Payroll Management (Admin & Staff only)
    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('payrolls', PayrollController::class);
        Route::get('payrolls/{payroll}/payslip', [PayrollController::class, 'generatePayslip'])->name('payrolls.payslip');
    });

    // Customer Management
    Route::resource('customers', CustomerController::class);

    // Vendor Management
    Route::resource('vendors', VendorController::class);

    // Shipment Management
    Route::resource('shipments', ShipmentController::class);

    // Vehicle Management
    Route::resource('vehicles', VehicleController::class);

    // Driver Management
    Route::resource('drivers', DriverController::class);

    // Invoice Management (Admin & Staff only)
    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::post('invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.status');
    });

    // Payment Management (Admin & Staff only)
    Route::middleware('role:admin,staff')->group(function () {
        Route::resource('payments', PaymentController::class);
    });

    // Reports (Admin & Staff only)
    Route::middleware('role:admin,staff')->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/shipments', [ReportController::class, 'shipments'])->name('reports.shipments');
        Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
        Route::get('reports/payroll', [ReportController::class, 'payroll'])->name('reports.payroll');
        Route::get('reports/vehicle-usage', [ReportController::class, 'vehicleUsage'])->name('reports.vehicle-usage');
        Route::get('reports/driver-performance', [ReportController::class, 'driverPerformance'])->name('reports.driver-performance');
        Route::get('reports/customer-wise', [ReportController::class, 'customerWise'])->name('reports.customer-wise');
        Route::get('reports/vendor-wise', [ReportController::class, 'vendorWise'])->name('reports.vendor-wise');
    });
});


