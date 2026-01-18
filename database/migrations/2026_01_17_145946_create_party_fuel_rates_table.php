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
        Schema::create('party_fuel_rates', function (Blueprint $table) {
            $table->id('fuel_rate_id');
            $table->string('party_type'); // Customer, Vendor, Driver, etc.
            $table->foreignId('party_id')->nullable(); // ID of customer/vendor/driver
            $table->string('party_code')->nullable();
            $table->string('party_name');
            $table->string('from_city');
            $table->string('to_city');
            $table->decimal('fuel_rate', 10, 2);
            $table->string('vehicle_type')->nullable();
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('party_type');
            $table->index('party_id');
            $table->index('from_city');
            $table->index('to_city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_fuel_rates');
    }
};
