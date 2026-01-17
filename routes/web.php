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
use App\Http\Controllers\SystemController;
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
        
        // Payroll System Module
        Route::prefix('payroll')->name('payroll.')->group(function () {
            Route::get('departments', [\App\Http\Controllers\PayrollModuleController::class, 'departments'])->name('departments');
            Route::post('departments', [\App\Http\Controllers\PayrollModuleController::class, 'storeDepartment'])->name('departments.store');
            Route::put('departments/{id}', [\App\Http\Controllers\PayrollModuleController::class, 'updateDepartment'])->name('departments.update');
            Route::delete('departments/{id}', [\App\Http\Controllers\PayrollModuleController::class, 'deleteDepartment'])->name('departments.delete');
            
            Route::get('designations', [\App\Http\Controllers\PayrollModuleController::class, 'designations'])->name('designations');
            Route::post('designations', [\App\Http\Controllers\PayrollModuleController::class, 'storeDesignation'])->name('designations.store');
            Route::put('designations/{id}', [\App\Http\Controllers\PayrollModuleController::class, 'updateDesignation'])->name('designations.update');
            Route::delete('designations/{id}', [\App\Http\Controllers\PayrollModuleController::class, 'deleteDesignation'])->name('designations.delete');
            
            Route::get('employee-master', [\App\Http\Controllers\PayrollModuleController::class, 'employeeMaster'])->name('employee-master');
            
            Route::get('loans', [\App\Http\Controllers\PayrollModuleController::class, 'loans'])->name('loans');
            Route::post('loans', [\App\Http\Controllers\PayrollModuleController::class, 'storeLoan'])->name('loans.store');
            Route::put('loans/{id}', [\App\Http\Controllers\PayrollModuleController::class, 'updateLoan'])->name('loans.update');
            Route::delete('loans/{id}', [\App\Http\Controllers\PayrollModuleController::class, 'deleteLoan'])->name('loans.delete');
            
            Route::get('deductions-allowances', [\App\Http\Controllers\PayrollModuleController::class, 'deductionsAllowances'])->name('deductions-allowances');
            Route::post('deductions-allowances', [\App\Http\Controllers\PayrollModuleController::class, 'storeDeductionAllowance'])->name('deductions-allowances.store');
            
            Route::get('authorized-leaves', [\App\Http\Controllers\PayrollModuleController::class, 'authorizedLeaves'])->name('authorized-leaves');
            Route::post('authorized-leaves', [\App\Http\Controllers\PayrollModuleController::class, 'storeAuthorizedLeave'])->name('authorized-leaves.store');
            
            Route::get('monthly-payroll-processing', [\App\Http\Controllers\PayrollModuleController::class, 'monthlyPayrollProcessing'])->name('monthly-payroll-processing');
            Route::post('process-payroll', [\App\Http\Controllers\PayrollModuleController::class, 'processPayroll'])->name('process-payroll');
        });
    });

    // Customer Management
    Route::resource('customers', CustomerController::class);

    // Vendor Management
    Route::resource('vendors', VendorController::class);

    // Shipment Management
    Route::resource('shipments', ShipmentController::class);
    Route::get('shipments/search/detail', [ShipmentController::class, 'detailSearch'])->name('shipments.detail-search');
    Route::post('shipments/search/results', [ShipmentController::class, 'searchResults'])->name('shipments.search-results');

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

           // City Management (Admin & Staff only)
           Route::middleware('role:admin,staff')->group(function () {
               Route::get('cities', [\App\Http\Controllers\CityController::class, 'index'])->name('cities.index');
               Route::post('cities', [\App\Http\Controllers\CityController::class, 'store'])->name('cities.store');
               Route::delete('cities/{id}', [\App\Http\Controllers\CityController::class, 'destroy'])->name('cities.destroy');
               Route::patch('cities/{id}/toggle-status', [\App\Http\Controllers\CityController::class, 'toggleStatus'])->name('cities.toggle-status');
           });

           // CN Book Management (Admin only)
           Route::middleware('role:admin')->group(function () {
               Route::resource('cn-books', \App\Http\Controllers\CNBookController::class);
               Route::post('cn-books/{cnBook}/refresh-counts', [\App\Http\Controllers\CNBookController::class, 'refreshCounts'])->name('cn-books.refresh-counts');
               Route::get('cn-books/{cnBook}/remaining-numbers', [\App\Http\Controllers\CNBookController::class, 'getRemainingNumbers'])->name('cn-books.remaining-numbers');
           });

           // City Selector (All authenticated users)
           Route::post('cities/switch', [\App\Http\Controllers\CityController::class, 'switchCity'])->name('cities.switch');
           Route::get('cities/accessible', [\App\Http\Controllers\CityController::class, 'getAccessibleCities'])->name('cities.accessible');

    // Reports (Admin & Staff only)
    Route::middleware('role:admin,staff')->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        
        // Logistics Reports
        Route::get('reports/shipments', [ReportController::class, 'shipments'])->name('reports.shipments');
        Route::get('reports/cn-detail', [ReportController::class, 'cnDetail'])->name('reports.cn-detail');
        Route::get('reports/cn-status', [ReportController::class, 'cnStatus'])->name('reports.cn-status');
        Route::get('reports/cn-profit-loss', [ReportController::class, 'cnProfitLoss'])->name('reports.cn-profit-loss');
        Route::get('reports/city-wise-profit-loss', [ReportController::class, 'cityWiseProfitLoss'])->name('reports.city-wise-profit-loss');
        Route::get('reports/shipper-wise-profit-loss', [ReportController::class, 'shipperWiseProfitLoss'])->name('reports.shipper-wise-profit-loss');
        Route::get('reports/delivery-cn-detail', [ReportController::class, 'deliveryCnDetail'])->name('reports.delivery-cn-detail');
        Route::get('reports/stock-in-transit', [ReportController::class, 'stockInTransit'])->name('reports.stock-in-transit');
        Route::get('reports/cn-in-stock', [ReportController::class, 'cnInStock'])->name('reports.cn-in-stock');
        Route::get('reports/vehicle-usage', [ReportController::class, 'vehicleUsage'])->name('reports.vehicle-usage');
        Route::get('reports/driver-performance', [ReportController::class, 'driverPerformance'])->name('reports.driver-performance');
        Route::get('reports/customer-wise', [ReportController::class, 'customerWise'])->name('reports.customer-wise');
        Route::get('reports/vendor-wise', [ReportController::class, 'vendorWise'])->name('reports.vendor-wise');
        
        // Finance Reports
        Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
        Route::get('reports/list-of-invoices', [ReportController::class, 'listOfInvoices'])->name('reports.list-of-invoices');
        Route::get('reports/list-of-pending-invoices', [ReportController::class, 'listOfPendingInvoices'])->name('reports.list-of-pending-invoices');
        Route::get('reports/list-of-missing-cn-nos', [ReportController::class, 'listOfMissingCnNos'])->name('reports.list-of-missing-cn-nos');
        Route::get('reports/group-party-outstanding', [ReportController::class, 'groupPartyOutstanding'])->name('reports.group-party-outstanding');
        Route::get('reports/list-of-city-codes', [\App\Http\Controllers\CityController::class, 'index'])->name('reports.list-of-city-codes');
        // Also allow direct access via cities route
        Route::get('cities', [\App\Http\Controllers\CityController::class, 'index'])->name('cities.index');
        Route::get('reports/list-of-vehicle-types', [ReportController::class, 'listOfVehicleTypes'])->name('reports.list-of-vehicle-types');
        Route::get('reports/payroll', [ReportController::class, 'payroll'])->name('reports.payroll');
        
        // Payroll Reports
        Route::get('reports/list-of-employees', [ReportController::class, 'listOfEmployees'])->name('reports.list-of-employees');
        Route::get('reports/list-of-monthly-deduction-allowances', [ReportController::class, 'listOfMonthlyDeductionAllowances'])->name('reports.list-of-monthly-deduction-allowances');
        Route::get('reports/employees-authorized-leaves-detail', [ReportController::class, 'employeesAuthorizedLeavesDetail'])->name('reports.employees-authorized-leaves-detail');
        Route::get('reports/employees-leaves-status', [ReportController::class, 'employeesLeavesStatus'])->name('reports.employees-leaves-status');
        Route::get('reports/department-wise-monthly-payroll-register', [ReportController::class, 'departmentWiseMonthlyPayrollRegister'])->name('reports.department-wise-monthly-payroll-register');
    });

    // Change Password (All authenticated users can access)
    Route::prefix('system')->name('system.')->group(function () {
        Route::get('change-password', [SystemController::class, 'changePassword'])->name('change-password');
        Route::post('change-password', [SystemController::class, 'updatePassword'])->name('update-password');
    });

    // System Management (Admin only)
    Route::middleware('role:admin')->group(function () {
        Route::prefix('system')->name('system.')->group(function () {
            // User Roles
            Route::get('user-roles', [SystemController::class, 'userRoles'])->name('user-roles');
            Route::post('user-roles/update', [SystemController::class, 'updateRolePermissions'])->name('update-role-permissions');
            
            // Change Year
            Route::get('change-year', [\App\Http\Controllers\SystemController::class, 'changeYear'])->name('change-year');
            Route::post('change-year', [\App\Http\Controllers\SystemController::class, 'updateYear'])->name('update-year');
            
            // Initialize Data for re-processing
            Route::get('initialize-data', [SystemController::class, 'initializeData'])->name('initialize-data');
            Route::post('initialize-data', [SystemController::class, 'processInitializeData'])->name('process-initialize-data');
            
            // Data Processing
            Route::get('data-processing', [SystemController::class, 'dataProcessing'])->name('data-processing');
            Route::post('data-processing', [SystemController::class, 'processData'])->name('process-data');
            
            // Payroll Processing - (FINAL)
            Route::get('payroll-processing-final', [SystemController::class, 'payrollProcessingFinal'])->name('payroll-processing-final');
            Route::post('payroll-processing-final', [SystemController::class, 'processPayrollFinal'])->name('process-payroll-final');
            
            // System Optimization
            Route::get('optimization', [SystemController::class, 'optimization'])->name('optimization');
            Route::post('optimization', [SystemController::class, 'runOptimization'])->name('run-optimization');
            
            // Un-Void C/N
            Route::get('unvoid-cn', [SystemController::class, 'unvoidCn'])->name('unvoid-cn');
            Route::post('unvoid-cn', [SystemController::class, 'processUnvoidCn'])->name('process-unvoid-cn');
            
            // E-mail Setting
            Route::get('email-settings', [SystemController::class, 'emailSettings'])->name('email-settings');
            Route::post('email-settings', [SystemController::class, 'updateEmailSettings'])->name('update-email-settings');
            
            // Inter Branches J.V Code
            Route::get('inter-branches-jv', [SystemController::class, 'interBranchesJv'])->name('inter-branches-jv');
            
            // Un-Post Data with Date Range
            Route::get('unpost-data', [SystemController::class, 'unpostData'])->name('unpost-data');
            Route::post('unpost-data', [SystemController::class, 'processUnpostData'])->name('process-unpost-data');
        });
    });
});


