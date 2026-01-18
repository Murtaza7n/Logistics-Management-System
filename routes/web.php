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

    // Logistics Module Routes
    Route::prefix('logistics')->name('logistics.')->group(function () {
        Route::get('initial-setup', [\App\Http\Controllers\LogisticsController::class, 'initialSetup'])->name('initial-setup');
        Route::get('other-cn-expense-sheet', [\App\Http\Controllers\LogisticsController::class, 'otherCnExpenseSheet'])->name('other-cn-expense-sheet');
        Route::post('other-cn-expense-sheet', [\App\Http\Controllers\LogisticsController::class, 'storeExpenseSheet'])->name('store-expense-sheet');
        Route::get('cn-delivery-reference-no', [\App\Http\Controllers\LogisticsController::class, 'cnDeliveryReferenceNo'])->name('cn-delivery-reference-no');
        Route::post('cn-delivery-reference-no', [\App\Http\Controllers\LogisticsController::class, 'storeDeliveryReference'])->name('store-delivery-reference');
        Route::get('party-fuel-rates', [\App\Http\Controllers\LogisticsController::class, 'partyFuelRates'])->name('party-fuel-rates');
        Route::post('party-fuel-rates', [\App\Http\Controllers\LogisticsController::class, 'storeFuelRate'])->name('store-fuel-rate');
    });

    // Finance Module Routes
    Route::prefix('finance')->name('finance.')->middleware('role:admin,staff')->group(function () {
        Route::get('group-codes', [\App\Http\Controllers\FinanceController::class, 'groupCodes'])->name('group-codes');
        Route::get('control-codes', [\App\Http\Controllers\FinanceController::class, 'controlCodes'])->name('control-codes');
        Route::get('account-grouping', [\App\Http\Controllers\FinanceController::class, 'accountGroups'])->name('account-grouping');
        Route::get('balance-sheet', [\App\Http\Controllers\FinanceController::class, 'balanceSheet'])->name('balance-sheet');
        Route::get('profit-loss', [\App\Http\Controllers\FinanceController::class, 'profitLoss'])->name('profit-loss');
        Route::get('change-voucher-date', [\App\Http\Controllers\FinanceController::class, 'changeVoucherDate'])->name('change-voucher-date');
        Route::get('list-of-chart-of-accounts', [\App\Http\Controllers\FinanceController::class, 'listOfChartOfAccounts'])->name('list-of-chart-of-accounts');
        Route::get('cn-wise-expenses-detail', [\App\Http\Controllers\FinanceController::class, 'cnWiseExpensesDetail'])->name('cn-wise-expenses-detail');
        Route::get('trial-balance', [\App\Http\Controllers\FinanceController::class, 'trialBalance'])->name('trial-balance');
        Route::get('master-schedule', [\App\Http\Controllers\FinanceController::class, 'masterSchedule'])->name('master-schedule');
        Route::get('accounts-ledger', [\App\Http\Controllers\FinanceController::class, 'accountsLedger'])->name('accounts-ledger');
        Route::get('profit-loss-comparative', [\App\Http\Controllers\FinanceController::class, 'profitLossComparative'])->name('profit-loss-comparative');
        Route::get('month-wise-closing-balance-breakup', [\App\Http\Controllers\FinanceController::class, 'monthWiseClosingBalanceBreakup'])->name('month-wise-closing-balance-breakup');
        Route::get('group-outstanding-detail', [\App\Http\Controllers\FinanceController::class, 'groupOutstandingDetail'])->name('group-outstanding-detail');
        Route::get('group-ledger', [\App\Http\Controllers\FinanceController::class, 'groupLedger'])->name('group-ledger');
        Route::get('trial-balance-console', [\App\Http\Controllers\FinanceController::class, 'trialBalanceConsole'])->name('trial-balance-console');
        Route::get('master-schedule-console', [\App\Http\Controllers\FinanceController::class, 'masterScheduleConsole'])->name('master-schedule-console');
        Route::get('accounts-ledger-console', [\App\Http\Controllers\FinanceController::class, 'accountsLedgerConsole'])->name('accounts-ledger-console');
        Route::get('pl-comparative-console', [\App\Http\Controllers\FinanceController::class, 'plComparativeConsole'])->name('pl-comparative-console');
        Route::get('account-grouping-detail', [\App\Http\Controllers\FinanceController::class, 'accountGroupingDetail'])->name('account-grouping-detail');
        Route::get('sales-tax-register-invoice-wise', [\App\Http\Controllers\FinanceController::class, 'salesTaxRegisterInvoiceWise'])->name('sales-tax-register-invoice-wise');
        Route::get('sales-tax-register-customer-wise', [\App\Http\Controllers\FinanceController::class, 'salesTaxRegisterCustomerWise'])->name('sales-tax-register-customer-wise');
        Route::get('party-wise-outstanding-detailed', [\App\Http\Controllers\FinanceController::class, 'partyWiseOutstandingDetailed'])->name('party-wise-outstanding-detailed');
        Route::get('party-wise-outstanding-aging', [\App\Http\Controllers\FinanceController::class, 'partyWiseOutstandingAging'])->name('party-wise-outstanding-aging');
        Route::get('party-wise-cleared-outstanding-detail', [\App\Http\Controllers\FinanceController::class, 'partyWiseClearedOutstandingDetail'])->name('party-wise-cleared-outstanding-detail');
    });

    // Chart of Accounts Routes
    Route::resource('chart-of-accounts', \App\Http\Controllers\ChartOfAccountController::class)->middleware('role:admin,staff');

    // Voucher Routes
    Route::prefix('vouchers')->name('vouchers.')->middleware('role:admin,staff')->group(function () {
        Route::get('/', [\App\Http\Controllers\VoucherController::class, 'index'])->name('index');
        Route::get('/create/{type?}', [\App\Http\Controllers\VoucherController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\VoucherController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\VoucherController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\VoucherController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\VoucherController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\VoucherController::class, 'destroy'])->name('destroy');
    });

    // Master Data Management Routes
    Route::prefix('master-data')->name('master-data.')->group(function () {
        // Item Codes
        Route::get('item-codes', [\App\Http\Controllers\MasterDataController::class, 'itemCodes'])->name('item-codes');
        Route::post('item-codes', [\App\Http\Controllers\MasterDataController::class, 'storeItemCode'])->name('item-codes.store');
        Route::put('item-codes/{id}', [\App\Http\Controllers\MasterDataController::class, 'updateItemCode'])->name('item-codes.update');
        Route::delete('item-codes/{id}', [\App\Http\Controllers\MasterDataController::class, 'deleteItemCode'])->name('item-codes.delete');
        
        // Container Sizes
        Route::get('container-sizes', [\App\Http\Controllers\MasterDataController::class, 'containerSizes'])->name('container-sizes');
        Route::post('container-sizes', [\App\Http\Controllers\MasterDataController::class, 'storeContainerSize'])->name('container-sizes.store');
        Route::put('container-sizes/{id}', [\App\Http\Controllers\MasterDataController::class, 'updateContainerSize'])->name('container-sizes.update');
        Route::delete('container-sizes/{id}', [\App\Http\Controllers\MasterDataController::class, 'deleteContainerSize'])->name('container-sizes.delete');
        
        // Invoice Charges
        Route::get('invoice-charges', [\App\Http\Controllers\MasterDataController::class, 'invoiceCharges'])->name('invoice-charges');
        Route::post('invoice-charges', [\App\Http\Controllers\MasterDataController::class, 'storeInvoiceCharge'])->name('invoice-charges.store');
        Route::put('invoice-charges/{id}', [\App\Http\Controllers\MasterDataController::class, 'updateInvoiceCharge'])->name('invoice-charges.update');
        Route::delete('invoice-charges/{id}', [\App\Http\Controllers\MasterDataController::class, 'deleteInvoiceCharge'])->name('invoice-charges.delete');
        
        // Cargo Officers
        Route::get('cargo-officers', [\App\Http\Controllers\MasterDataController::class, 'cargoOfficers'])->name('cargo-officers');
        Route::post('cargo-officers', [\App\Http\Controllers\MasterDataController::class, 'storeCargoOfficer'])->name('cargo-officers.store');
        Route::put('cargo-officers/{id}', [\App\Http\Controllers\MasterDataController::class, 'updateCargoOfficer'])->name('cargo-officers.update');
        Route::delete('cargo-officers/{id}', [\App\Http\Controllers\MasterDataController::class, 'deleteCargoOfficer'])->name('cargo-officers.delete');
        
        // Cargo Officer Stock Issue
        Route::get('cargo-officer-stock-issue', [\App\Http\Controllers\MasterDataController::class, 'cargoOfficerStockIssue'])->name('cargo-officer-stock-issue');
        
        // Zone Codes
        Route::get('zone-codes', [\App\Http\Controllers\MasterDataController::class, 'zoneCodes'])->name('zone-codes');
        Route::post('zone-codes', [\App\Http\Controllers\MasterDataController::class, 'storeZoneCode'])->name('zone-codes.store');
        Route::put('zone-codes/{id}', [\App\Http\Controllers\MasterDataController::class, 'updateZoneCode'])->name('zone-codes.update');
        Route::delete('zone-codes/{id}', [\App\Http\Controllers\MasterDataController::class, 'deleteZoneCode'])->name('zone-codes.delete');
        
        // Party/Area Rates
        Route::get('party-area-rates', [\App\Http\Controllers\MasterDataController::class, 'partyAreaRates'])->name('party-area-rates');
        Route::post('party-area-rates', [\App\Http\Controllers\MasterDataController::class, 'storePartyAreaRate'])->name('party-area-rates.store');
        Route::put('party-area-rates/{id}', [\App\Http\Controllers\MasterDataController::class, 'updatePartyAreaRate'])->name('party-area-rates.update');
        Route::delete('party-area-rates/{id}', [\App\Http\Controllers\MasterDataController::class, 'deletePartyAreaRate'])->name('party-area-rates.delete');
    });

    // Booking Management
    Route::resource('bookings', \App\Http\Controllers\BookingController::class);

    // Vehicle Load Plan Management
    Route::prefix('vehicle-load-plans')->name('vehicle-load-plans.')->group(function () {
        Route::get('/', [\App\Http\Controllers\VehicleLoadPlanController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\VehicleLoadPlanController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\VehicleLoadPlanController::class, 'store'])->name('store');
        Route::get('/{id}', [\App\Http\Controllers\VehicleLoadPlanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [\App\Http\Controllers\VehicleLoadPlanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\VehicleLoadPlanController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\VehicleLoadPlanController::class, 'destroy'])->name('destroy');
        Route::get('/received', [\App\Http\Controllers\VehicleLoadPlanController::class, 'received'])->name('received');
    });

    // Delivery Sheet Management
    Route::resource('delivery-sheets', \App\Http\Controllers\DeliverySheetController::class);

    // Pickup Sheet Management
    Route::resource('pickup-sheets', \App\Http\Controllers\PickupSheetController::class);

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

    // Purchases (Placeholder - to be implemented)
    Route::prefix('purchases')->name('purchases.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('dashboard')->with('info', 'Purchases module coming soon.');
        })->name('index');
        Route::get('/create', function () {
            return redirect()->route('dashboard')->with('info', 'Purchases module coming soon.');
        })->name('create');
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
        
        // Logistics Reports - Sales Reports
        Route::get('reports/shipments', [ReportController::class, 'shipments'])->name('reports.shipments');
        Route::get('reports/cn-detail', [ReportController::class, 'cnDetail'])->name('reports.cn-detail');
        Route::get('reports/cn-status', [ReportController::class, 'cnStatus'])->name('reports.cn-status');
        Route::get('reports/cn-profit-loss', [ReportController::class, 'cnProfitLoss'])->name('reports.cn-profit-loss');
        Route::get('reports/city-wise-profit-loss', [ReportController::class, 'cityWiseProfitLoss'])->name('reports.city-wise-profit-loss');
        Route::get('reports/shipper-wise-profit-loss', [ReportController::class, 'shipperWiseProfitLoss'])->name('reports.shipper-wise-profit-loss');
        Route::get('reports/hub-wise-profit-loss', [ReportController::class, 'hubWiseProfitLoss'])->name('reports.hub-wise-profit-loss');
        Route::get('reports/spo-wise-profit-loss', [ReportController::class, 'spoWiseProfitLoss'])->name('reports.spo-wise-profit-loss');
        Route::get('reports/hub-wise-cn-detail', [ReportController::class, 'hubWiseCnDetail'])->name('reports.hub-wise-cn-detail');
        Route::get('reports/transporter-wise-documents-detail', [ReportController::class, 'transporterWiseDocumentsDetail'])->name('reports.transporter-wise-documents-detail');
        Route::get('reports/zone-wise-profit-loss', [ReportController::class, 'zoneWiseProfitLoss'])->name('reports.zone-wise-profit-loss');
        
        // Logistics Reports - Edit Lists
        Route::get('reports/list-of-missing-sn-numbers', [ReportController::class, 'listOfMissingSnNumbers'])->name('reports.list-of-missing-sn-numbers');
        Route::get('reports/city-code-hub-wise-list', [ReportController::class, 'cityCodeHubWiseList'])->name('reports.city-code-hub-wise-list');
        Route::get('reports/list-of-rates', [ReportController::class, 'listOfRates'])->name('reports.list-of-rates');
        Route::get('reports/party-wise-fuel-rate-list', [ReportController::class, 'partyWiseFuelRateList'])->name('reports.party-wise-fuel-rate-list');
        
        // Logistics Reports - Other Reports
        Route::get('reports/delivery-cn-detail', [ReportController::class, 'deliveryCnDetail'])->name('reports.delivery-cn-detail');
        Route::get('reports/stock-in-transit', [ReportController::class, 'stockInTransit'])->name('reports.stock-in-transit');
        Route::get('reports/cn-in-stock', [ReportController::class, 'cnInStock'])->name('reports.cn-in-stock');
        Route::get('reports/list-of-invoices-sales-tax', [ReportController::class, 'listOfInvoicesSalesTax'])->name('reports.list-of-invoices-sales-tax');
        Route::get('reports/cn-detail-account-cod', [ReportController::class, 'cnDetailAccountCod'])->name('reports.cn-detail-account-cod');
        Route::get('reports/delivery-sheet-cod-detail', [ReportController::class, 'deliverySheetCodDetail'])->name('reports.delivery-sheet-cod-detail');
        Route::get('reports/cn-detail-account-cod-status', [ReportController::class, 'cnDetailAccountCodStatus'])->name('reports.cn-detail-account-cod-status');
        Route::get('reports/non-service-charges-on-cn', [ReportController::class, 'nonServiceChargesOnCn'])->name('reports.non-service-charges-on-cn');
        
        // Legacy Reports (kept for backward compatibility)
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
        Route::get('reports/list-of-monthly-payroll', [ReportController::class, 'listOfMonthlyPayroll'])->name('reports.list-of-monthly-payroll');
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


