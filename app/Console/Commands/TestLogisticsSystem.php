<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Employee;
use App\Models\City;
use App\Models\CNBook;
use App\Models\Shipment;
use App\Models\CNNumberUsage;
use App\Models\UserCityPermission;
use App\Models\Customer;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TestLogisticsSystem extends Command
{
    protected $signature = 'test:logistics-system {--cleanup : Clean up test data only}';
    protected $description = 'Test the entire logistics system end-to-end and optionally clean up test data';

    private $testData = [
        'users' => [],
        'employees' => [],
        'cities' => [],
        'cnBooks' => [],
        'shipments' => [],
        'customers' => [],
        'vendors' => [],
    ];

    public function handle()
    {
        if ($this->option('cleanup')) {
            return $this->cleanupTestData();
        }

        $this->info('=== Starting End-to-End Logistics System Testing ===');
        $this->newLine();

        try {
            DB::beginTransaction();

            // 1. Create Test Cities
            $this->info('1. Creating test cities...');
            $this->createTestCities();

            // 2. Create Test CN Books
            $this->info('2. Creating test CN books...');
            $this->createTestCNBooks();

            // 3. Create Test Employees
            $this->info('3. Creating test employees...');
            $this->createTestEmployees();

            // 4. Create Test Users
            $this->info('4. Creating test users with permissions...');
            $this->createTestUsers();

            // 5. Test CN Book Validation
            $this->info('5. Testing CN book validation...');
            $this->testCNBookValidation();

            // 6. Test Shipment Creation
            $this->info('6. Testing shipment creation...');
            $this->testShipmentCreation();

            // 7. Test City Permissions
            $this->info('7. Testing city permissions...');
            $this->testCityPermissions();

            // 8. Test Reports
            $this->info('8. Testing reports...');
            $this->testReports();

            DB::commit();

            $this->newLine();
            $this->info('=== Testing Complete ===');
            $this->info('Test data created. Use --cleanup flag to remove test data.');
            $this->displayTestSummary();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Testing failed: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }

        return 0;
    }

    private function createTestCities()
    {
        $testCities = [
            ['name' => 'Test City Alpha', 'code' => 'TCA', 'state' => 'Test State', 'country' => 'Pakistan'],
            ['name' => 'Test City Beta', 'code' => 'TCB', 'state' => 'Test State', 'country' => 'Pakistan'],
            ['name' => 'Test City Gamma', 'code' => 'TCG', 'state' => 'Test State', 'country' => 'Pakistan'],
        ];

        foreach ($testCities as $cityData) {
            $city = City::firstOrCreate(
                ['code' => $cityData['code']],
                $cityData
            );
            $this->testData['cities'][] = $city;
            $this->line("  ✓ Created city: {$city->name} ({$city->code})");
        }
    }

    private function createTestCNBooks()
    {
        if (empty($this->testData['cities'])) {
            $this->error('No test cities available');
            return;
        }

        $city = $this->testData['cities'][0];
        $systemYear = '2526';

        $cnBook = CNBook::create([
            'book_number' => 'TEST-BOOK-001',
            'book_name' => 'Test CN Book 001',
            'city_code' => $city->code,
            'system_year' => $systemYear,
            'start_number' => 1000,
            'end_number' => 1050,
            'total_numbers' => 51,
            'issued_count' => 0,
            'remaining_count' => 51,
            'status' => 'active',
            'issue_date' => now(),
        ]);

        $this->testData['cnBooks'][] = $cnBook;
        $this->line("  ✓ Created CN Book: {$cnBook->book_number} (Range: 1000-1050)");

        // Create second test book
        $cnBook2 = CNBook::create([
            'book_number' => 'TEST-BOOK-002',
            'book_name' => 'Test CN Book 002',
            'city_code' => $city->code,
            'system_year' => $systemYear,
            'start_number' => 2000,
            'end_number' => 2050,
            'total_numbers' => 51,
            'issued_count' => 0,
            'remaining_count' => 51,
            'status' => 'active',
            'issue_date' => now(),
        ]);

        $this->testData['cnBooks'][] = $cnBook2;
        $this->line("  ✓ Created CN Book: {$cnBook2->book_number} (Range: 2000-2050)");
    }

    private function createTestEmployees()
    {
        $testEmployees = [
            ['name' => 'Test Employee Alpha', 'role' => 'Manager', 'contact' => '0300-1111111', 'email' => 'test.alpha@test.com'],
            ['name' => 'Test Employee Beta', 'role' => 'Staff', 'contact' => '0300-2222222', 'email' => 'test.beta@test.com'],
        ];

        foreach ($testEmployees as $empData) {
            $employee = Employee::create($empData);
            $this->testData['employees'][] = $employee;
            $this->line("  ✓ Created employee: {$employee->name} (ID: {$employee->emp_id})");
        }
    }

    private function createTestUsers()
    {
        // Test Admin User
        $adminUser = User::create([
            'name' => 'Test Admin User',
            'email' => 'testadmin@test.com',
            'password' => Hash::make('test123456'),
            'role' => 'admin',
            'primary_city_id' => $this->testData['cities'][0]->city_id ?? null,
        ]);
        $this->testData['users'][] = $adminUser;
        $this->line("  ✓ Created admin user: {$adminUser->name} (Email: {$adminUser->email})");

        // Test Staff User with City Permissions
        if (!empty($this->testData['cities'])) {
            $staffUser = User::create([
                'name' => 'Test Staff User',
                'email' => 'teststaff@test.com',
                'password' => Hash::make('test123456'),
                'role' => 'staff',
                'primary_city_id' => $this->testData['cities'][0]->city_id,
            ]);

            // Assign city permissions
            foreach ($this->testData['cities'] as $city) {
                UserCityPermission::create([
                    'user_id' => $staffUser->id,
                    'city_id' => $city->city_id,
                    'can_view_reports' => true,
                    'can_create_bookings' => true,
                    'can_edit_bookings' => true,
                    'can_delete_bookings' => false,
                ]);
            }

            $this->testData['users'][] = $staffUser;
            $this->line("  ✓ Created staff user: {$staffUser->name} with city permissions");
        }

        // Test Driver User
        $driverUser = User::create([
            'name' => 'Test Driver User',
            'email' => 'testdriver@test.com',
            'password' => Hash::make('test123456'),
            'role' => 'driver',
            'primary_city_id' => $this->testData['cities'][0]->city_id ?? null,
        ]);
        $this->testData['users'][] = $driverUser;
        $this->line("  ✓ Created driver user: {$driverUser->name}");
    }

    private function testCNBookValidation()
    {
        if (empty($this->testData['cnBooks'])) {
            $this->warn('  ⚠ No CN books to test');
            return;
        }

        $cnBook = $this->testData['cnBooks'][0];
        $this->line("  Testing CN Book: {$cnBook->book_number}");

        // Test getNextAvailableNumber
        $nextNumber = $cnBook->getNextAvailableNumber();
        if ($nextNumber === $cnBook->start_number) {
            $this->line("  ✓ Next available number: {$nextNumber} (correct)");
        } else {
            $this->error("  ✗ Next available number incorrect: {$nextNumber}");
        }

        // Test isNumberAvailable
        $isAvailable = $cnBook->isNumberAvailable($cnBook->start_number);
        if ($isAvailable) {
            $this->line("  ✓ Number {$cnBook->start_number} is available (correct)");
        } else {
            $this->error("  ✗ Number {$cnBook->start_number} should be available");
        }

        // Test isLowStock
        $isLowStock = $cnBook->isLowStock();
        $this->line("  ✓ Low stock check: " . ($isLowStock ? 'Yes' : 'No'));
    }

    private function testShipmentCreation()
    {
        if (empty($this->testData['cnBooks']) || empty($this->testData['cities'])) {
            $this->warn('  ⚠ Missing test data for shipment creation');
            return;
        }

        $cnBook = $this->testData['cnBooks'][0];
        $city = $this->testData['cities'][0];

        // Create test customer
        $customer = Customer::create([
            'name' => 'Test Customer Alpha',
            'email' => 'testcustomer@test.com',
            'contact' => '0300-3333333',
            'address' => 'Test Address',
            'status' => 'active',
            'account_code' => 'TEST-CUST-001',
        ]);
        $this->testData['customers'][] = $customer;

        // Create test vendor
        $vendor = Vendor::create([
            'name' => 'Test Vendor Alpha',
            'email' => 'testvendor@test.com',
            'contact' => '0300-4444444',
            'address' => 'Test Address',
            'status' => 'active',
            'account_code' => 'TEST-VEND-001',
        ]);
        $this->testData['vendors'][] = $vendor;

        // Get next CN number
        $nextNumber = $cnBook->getNextAvailableNumber();
        $cnNumber = sprintf('%s-%s-%06d', $cnBook->system_year, $cnBook->city_code, $nextNumber);

        // Create test shipment (without cn_book_id as column may not exist)
        $shipmentData = [
            'shipment_number' => $cnNumber,
            'system_year' => $cnBook->system_year,
            'entry_city' => $city->city_id,
            'customer_id' => $customer->customer_id,
            'vendor_id' => $vendor->vendor_id,
            'shipper_name' => 'Test Shipper',
            'consignee_name' => 'Test Consignee',
            'pickup_city' => 'Test Pickup',
            'delivery_city' => 'Test Delivery',
            'cargo_type' => 'Test Cargo',
            'status' => 'booked',
            'sender' => 'Test Sender',
            'receiver' => 'Test Receiver',
        ];
        
        // Only add cn_book_id if column exists
        try {
            $columns = DB::select("SHOW COLUMNS FROM shipments WHERE Field = 'cn_book_id'");
            if (!empty($columns)) {
                $shipmentData['cn_book_id'] = $cnBook->id;
            }
        } catch (\Exception $e) {
            // Column doesn't exist, continue without it
        }
        
        $shipment = Shipment::create($shipmentData);

        // Issue CN number
        $usage = CNNumberUsage::create([
            'cn_book_id' => $cnBook->id,
            'cn_number' => $cnNumber,
            'shipment_id' => $shipment->shipment_id,
            'issued_by' => $this->testData['users'][0]->id ?? 1,
            'issued_at' => now(),
            'status' => 'issued',
        ]);

        $cnBook->updateCounts();

        $this->testData['shipments'][] = $shipment;
        $this->line("  ✓ Created test shipment: {$cnNumber}");
        $this->line("  ✓ CN number issued and tracked");
    }

    private function testCityPermissions()
    {
        $staffUser = collect($this->testData['users'])->firstWhere('role', 'staff');
        if (!$staffUser) {
            $this->warn('  ⚠ No staff user to test permissions');
            return;
        }

        $this->line("  Testing permissions for: {$staffUser->name}");

        foreach ($this->testData['cities'] as $city) {
            $accessibleCities = $staffUser->accessibleCities();
            $canAccess = $accessibleCities->contains('city_id', $city->city_id);
            
            $permission = UserCityPermission::where('user_id', $staffUser->id)
                ->where('city_id', $city->city_id)
                ->first();
            
            $canView = $permission ? ($permission->can_view_reports ?? false) : false;
            $canCreate = $permission ? ($permission->can_create_bookings ?? false) : false;

            $this->line("  ✓ City {$city->name}: Access=" . ($canAccess ? 'Yes' : 'No') . ", View=" . ($canView ? 'Yes' : 'No') . ", Create=" . ($canCreate ? 'Yes' : 'No'));
        }
    }

    private function testReports()
    {
        $this->line("  Testing report data availability...");

        $shipmentCount = Shipment::count();
        $this->line("  ✓ Total shipments: {$shipmentCount}");

        $cnBookCount = CNBook::count();
        $this->line("  ✓ Total CN books: {$cnBookCount}");

        $cityCount = City::count();
        $this->line("  ✓ Total cities: {$cityCount}");

        $userCount = User::count();
        $this->line("  ✓ Total users: {$userCount}");
    }

    private function displayTestSummary()
    {
        $this->newLine();
        $this->info('=== Test Data Summary ===');
        $this->line("Test Cities: " . count($this->testData['cities']));
        $this->line("Test CN Books: " . count($this->testData['cnBooks']));
        $this->line("Test Employees: " . count($this->testData['employees']));
        $this->line("Test Users: " . count($this->testData['users']));
        $this->line("Test Shipments: " . count($this->testData['shipments']));
        $this->line("Test Customers: " . count($this->testData['customers']));
        $this->line("Test Vendors: " . count($this->testData['vendors']));
    }

    private function cleanupTestData()
    {
        $this->info('=== Cleaning Up Test Data ===');
        $this->newLine();

        try {
            DB::beginTransaction();

            // Delete test shipments and CN number usages
            $this->info('1. Deleting test shipments and CN number usages...');
            $testShipments = Shipment::where('shipment_number', 'like', '%TEST%')
                ->orWhere('shipment_number', 'like', '2526-TCA-%')
                ->orWhere('shipment_number', 'like', '2526-TCB-%')
                ->orWhere('shipment_number', 'like', '2526-TCG-%')
                ->get();

            foreach ($testShipments as $shipment) {
                CNNumberUsage::where('shipment_id', $shipment->shipment_id)->delete();
                $shipment->delete();
            }
            $this->line("  ✓ Deleted " . $testShipments->count() . " test shipments");

            // Delete test CN number usages
            $testUsages = CNNumberUsage::where('cn_number', 'like', '%TEST%')
                ->orWhere('cn_number', 'like', '2526-TCA-%')
                ->orWhere('cn_number', 'like', '2526-TCB-%')
                ->orWhere('cn_number', 'like', '2526-TCG-%')
                ->get();
            foreach ($testUsages as $usage) {
                $usage->delete();
            }
            $this->line("  ✓ Deleted " . $testUsages->count() . " test CN number usages");

            // Update CN book counts
            $this->info('2. Updating CN book counts...');
            CNBook::where('book_number', 'like', 'TEST-%')->each(function ($book) {
                $book->updateCounts();
            });
            $this->line("  ✓ Updated CN book counts");

            // Delete test CN books
            $this->info('3. Deleting test CN books...');
            $testBooks = CNBook::where('book_number', 'like', 'TEST-%')->get();
            foreach ($testBooks as $book) {
                $book->delete();
            }
            $this->line("  ✓ Deleted " . $testBooks->count() . " test CN books");

            // Delete test users and their permissions
            $this->info('4. Deleting test users...');
            $testUsers = User::where('email', 'like', '%test%@test.com')->get();
            foreach ($testUsers as $user) {
                UserCityPermission::where('user_id', $user->id)->delete();
                $user->delete();
            }
            $this->line("  ✓ Deleted " . $testUsers->count() . " test users");

            // Delete test employees
            $this->info('5. Deleting test employees...');
            $testEmployees = Employee::where('email', 'like', '%test%@test.com')
                ->orWhere('name', 'like', 'Test Employee%')
                ->get();
            foreach ($testEmployees as $employee) {
                $employee->delete();
            }
            $this->line("  ✓ Deleted " . $testEmployees->count() . " test employees");

            // Delete test customers
            $this->info('6. Deleting test customers...');
            $testCustomers = Customer::where('name', 'like', 'Test Customer%')
                ->orWhere('account_code', 'like', 'TEST-%')
                ->get();
            foreach ($testCustomers as $customer) {
                $customer->delete();
            }
            $this->line("  ✓ Deleted " . $testCustomers->count() . " test customers");

            // Delete test vendors
            $this->info('7. Deleting test vendors...');
            $testVendors = Vendor::where('name', 'like', 'Test Vendor%')
                ->orWhere('account_code', 'like', 'TEST-%')
                ->get();
            foreach ($testVendors as $vendor) {
                $vendor->delete();
            }
            $this->line("  ✓ Deleted " . $testVendors->count() . " test vendors");

            // Delete test cities
            $this->info('8. Deleting test cities...');
            $testCities = City::where('code', 'like', 'TC%')
                ->orWhere('name', 'like', 'Test City%')
                ->get();
            foreach ($testCities as $city) {
                // Check if city is in use
                $shipmentCount = Shipment::where('entry_city', $city->city_id)->count();
                if ($shipmentCount > 0) {
                    $this->warn("  ⚠ City {$city->name} has {$shipmentCount} shipments, marking as inactive instead");
                    $city->is_active = false;
                    $city->save();
                } else {
                    $city->delete();
                    $this->line("  ✓ Deleted city: {$city->name}");
                }
            }

            DB::commit();

            $this->newLine();
            $this->info('=== Cleanup Complete ===');
            $this->info('All test data has been removed from the system.');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Cleanup failed: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}

