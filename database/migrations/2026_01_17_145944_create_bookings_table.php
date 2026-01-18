<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id');
            $table->string('booking_number')->unique();
            $table->string('system_year')->default('2526');
            $table->date('booking_date');
            $table->foreignId('customer_id')->nullable()->constrained('customers', 'customer_id')->onDelete('set null');
            $table->foreignId('vendor_id')->nullable()->constrained('vendors', 'vendor_id')->onDelete('set null');
            $table->string('shipper_code')->nullable();
            $table->string('shipper_name');
            $table->text('shipper_address_line1')->nullable();
            $table->text('shipper_address_line2')->nullable();
            $table->text('shipper_address_line3')->nullable();
            $table->string('shipper_contact')->nullable();
            $table->string('consignee_code')->nullable();
            $table->string('consignee_name');
            $table->text('consignee_address_line1')->nullable();
            $table->text('consignee_address_line2')->nullable();
            $table->text('consignee_address_line3')->nullable();
            $table->string('consignee_contact')->nullable();
            $table->string('pickup_city');
            $table->string('delivery_city');
            $table->string('cargo_type')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('estimated_freight', 10, 2)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('booking_number');
            $table->index('system_year');
            $table->index('booking_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
