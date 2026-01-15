<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Shipment;
use App\Models\Payroll;
use App\Models\Invoice;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@logistics.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $staff = User::create([
            'name' => 'Staff User',
            'email' => 'staff@logistics.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        $driver = User::create([
            'name' => 'Driver User',
            'email' => 'driver@logistics.com',
            'password' => Hash::make('password'),
            'role' => 'driver',
        ]);

        // Create Employees
        $emp1 = Employee::create([
            'name' => 'John Doe',
            'role' => 'manager',
            'contact' => '+1234567890',
            'email' => 'john@example.com',
            'address' => '123 Main St, City',
            'bank_account' => '1234567890',
            'bank_name' => 'Bank of America',
            'hire_date' => now()->subYears(2),
            'status' => 'active',
        ]);

        $emp2 = Employee::create([
            'name' => 'Jane Smith',
            'role' => 'staff',
            'contact' => '+1234567891',
            'email' => 'jane@example.com',
            'address' => '456 Oak Ave, City',
            'bank_account' => '0987654321',
            'bank_name' => 'Chase Bank',
            'hire_date' => now()->subYear(),
            'status' => 'active',
        ]);

        // Create Customers
        $customer1 = Customer::create([
            'name' => 'ABC Corporation',
            'contact' => '+1987654321',
            'email' => 'contact@abccorp.com',
            'address' => '789 Business Park, New York',
            'city' => 'New York',
            'state' => 'NY',
            'country' => 'USA',
            'tax_id' => 'TAX123456',
            'status' => 'active',
        ]);

        $customer2 = Customer::create([
            'name' => 'XYZ Industries',
            'contact' => '+1987654322',
            'email' => 'info@xyzind.com',
            'address' => '321 Industrial Way, Los Angeles',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'country' => 'USA',
            'tax_id' => 'TAX789012',
            'status' => 'active',
        ]);

        // Create Vendors
        $vendor1 = Vendor::create([
            'name' => 'Fast Logistics Co',
            'services' => 'Warehousing, Distribution, Last-mile delivery',
            'contact' => '+1555123456',
            'email' => 'contact@fastlog.com',
            'address' => '555 Warehouse Blvd, Chicago',
            'billing_terms' => 'Net 30',
            'tax_id' => 'VTAX123456',
            'status' => 'active',
        ]);

        // Create Vehicles
        $vehicle1 = Vehicle::create([
            'type' => 'Truck',
            'registration_no' => 'TRK-001',
            'make' => 'Ford',
            'model' => 'F-150',
            'year' => 2020,
            'capacity' => 5000.00,
            'status' => 'available',
            'purchase_date' => now()->subYears(1),
        ]);

        $vehicle2 = Vehicle::create([
            'type' => 'Van',
            'registration_no' => 'VAN-001',
            'make' => 'Mercedes',
            'model' => 'Sprinter',
            'year' => 2021,
            'capacity' => 2000.00,
            'status' => 'available',
            'purchase_date' => now()->subMonths(6),
        ]);

        // Create Drivers
        $driver1 = Driver::create([
            'name' => 'Mike Johnson',
            'license_no' => 'DL123456',
            'contact' => '+1555987654',
            'email' => 'mike@example.com',
            'address' => '111 Driver St, City',
            'assigned_vehicle' => $vehicle1->vehicle_id,
            'license_expiry' => now()->addYears(2),
            'status' => 'available',
        ]);

        $driver2 = Driver::create([
            'name' => 'Tom Wilson',
            'license_no' => 'DL789012',
            'contact' => '+1555987655',
            'email' => 'tom@example.com',
            'address' => '222 Road Ave, City',
            'assigned_vehicle' => $vehicle2->vehicle_id,
            'license_expiry' => now()->addYears(1),
            'status' => 'available',
        ]);

        // Update vehicle status
        $vehicle1->update(['status' => 'in-use']);
        $vehicle2->update(['status' => 'in-use']);

        // Create Shipments
        $shipment1 = Shipment::create([
            'shipment_number' => 'SHIP-001',
            'customer_id' => $customer1->customer_id,
            'vendor_id' => $vendor1->vendor_id,
            'sender' => 'ABC Corporation',
            'receiver' => 'XYZ Industries',
            'sender_contact' => '+1987654321',
            'receiver_contact' => '+1987654322',
            'pickup_city' => 'New York',
            'delivery_city' => 'Los Angeles',
            'pickup_address' => '789 Business Park, New York',
            'delivery_address' => '321 Industrial Way, Los Angeles',
            'cargo_type' => 'Electronics',
            'weight' => 500.00,
            'dimension' => '10x5x3 ft',
            'quantity' => 10,
            'freight_charges' => 1500.00,
            'labor_charges' => 200.00,
            'other_charges' => 100.00,
            'status' => 'in-transit',
            'vehicle_id' => $vehicle1->vehicle_id,
            'driver_id' => $driver1->driver_id,
            'pickup_date' => now()->subDays(2),
            'delivery_date' => now()->addDays(3),
        ]);

        $shipment2 = Shipment::create([
            'shipment_number' => 'SHIP-002',
            'customer_id' => $customer2->customer_id,
            'sender' => 'XYZ Industries',
            'receiver' => 'ABC Corporation',
            'sender_contact' => '+1987654322',
            'receiver_contact' => '+1987654321',
            'pickup_city' => 'Los Angeles',
            'delivery_city' => 'New York',
            'pickup_address' => '321 Industrial Way, Los Angeles',
            'delivery_address' => '789 Business Park, New York',
            'cargo_type' => 'Fragile',
            'weight' => 300.00,
            'dimension' => '8x4x2 ft',
            'quantity' => 5,
            'freight_charges' => 1200.00,
            'labor_charges' => 150.00,
            'other_charges' => 50.00,
            'status' => 'booked',
            'vehicle_id' => $vehicle2->vehicle_id,
            'driver_id' => $driver2->driver_id,
            'pickup_date' => now()->addDays(1),
            'delivery_date' => now()->addDays(5),
        ]);

        $shipment3 = Shipment::create([
            'shipment_number' => 'SHIP-003',
            'customer_id' => $customer1->customer_id,
            'sender' => 'ABC Corporation',
            'receiver' => 'Local Business',
            'sender_contact' => '+1987654321',
            'receiver_contact' => '+1555111111',
            'pickup_city' => 'New York',
            'delivery_city' => 'Boston',
            'pickup_address' => '789 Business Park, New York',
            'delivery_address' => '999 Main St, Boston',
            'cargo_type' => 'General',
            'weight' => 200.00,
            'dimension' => '6x3x2 ft',
            'quantity' => 3,
            'freight_charges' => 800.00,
            'labor_charges' => 100.00,
            'other_charges' => 0.00,
            'status' => 'delivered',
            'pickup_date' => now()->subDays(10),
            'delivery_date' => now()->subDays(5),
            'actual_delivery_date' => now()->subDays(5),
        ]);

        // Create Payroll
        Payroll::create([
            'emp_id' => $emp1->emp_id,
            'month' => now()->format('Y-m'),
            'basic_salary' => 5000.00,
            'overtime' => 500.00,
            'bonus' => 200.00,
            'deductions' => 300.00,
            'deduction_details' => 'Health Insurance, Tax',
            'net_salary' => 5400.00,
            'status' => 'paid',
            'payment_date' => now()->subDays(5),
        ]);

        Payroll::create([
            'emp_id' => $emp2->emp_id,
            'month' => now()->format('Y-m'),
            'basic_salary' => 3500.00,
            'overtime' => 200.00,
            'bonus' => 0.00,
            'deductions' => 200.00,
            'deduction_details' => 'Health Insurance',
            'net_salary' => 3500.00,
            'status' => 'paid',
            'payment_date' => now()->subDays(5),
        ]);

        // Create Invoice
        $invoice1 = Invoice::create([
            'invoice_number' => 'INV-2024-00001',
            'invoice_type' => 'customer',
            'customer_id' => $customer1->customer_id,
            'invoice_date' => now()->subDays(1),
            'due_date' => now()->addDays(29),
            'subtotal' => 1800.00,
            'tax_rate' => 10.00,
            'tax_amount' => 180.00,
            'discount' => 0.00,
            'total' => 1980.00,
            'status' => 'sent',
        ]);

        $invoice1->shipments()->attach($shipment1->shipment_id, ['amount' => 1800.00]);

        // Create Payment
        Payment::create([
            'invoice_id' => $invoice1->invoice_id,
            'amount_paid' => 1000.00,
            'payment_date' => now()->subDays(1),
            'method' => 'bank_transfer',
            'reference_number' => 'PAY-001',
        ]);
    }
}


