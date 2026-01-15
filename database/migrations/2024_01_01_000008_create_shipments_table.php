<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id('shipment_id');
            $table->string('shipment_number')->unique(); // Manual entry
            $table->foreignId('customer_id')->constrained('customers', 'customer_id')->onDelete('cascade');
            $table->foreignId('vendor_id')->nullable()->constrained('vendors', 'vendor_id')->onDelete('set null');
            $table->string('sender');
            $table->string('receiver');
            $table->string('sender_contact')->nullable();
            $table->string('receiver_contact')->nullable();
            $table->string('pickup_city');
            $table->string('delivery_city');
            $table->text('pickup_address')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('cargo_type'); // Fragile, General, Liquid, etc.
            $table->decimal('weight', 8, 2)->nullable(); // in kg
            $table->string('dimension')->nullable(); // L x W x H
            $table->integer('quantity')->default(1);
            $table->decimal('freight_charges', 10, 2)->default(0);
            $table->decimal('labor_charges', 10, 2)->default(0);
            $table->decimal('other_charges', 10, 2)->default(0);
            $table->enum('status', ['booked', 'picked-up', 'in-transit', 'out-for-delivery', 'delivered', 'cancelled'])->default('booked');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles', 'vehicle_id')->onDelete('set null');
            $table->foreignId('driver_id')->nullable()->constrained('drivers', 'driver_id')->onDelete('set null');
            $table->date('pickup_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('actual_delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};


