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
        Schema::create('party_area_rates', function (Blueprint $table) {
            $table->id();
            $table->string('party_type')->nullable(); // Customer, Vendor, Area
            $table->string('party_code')->nullable();
            $table->string('party_name')->nullable();
            $table->string('from_city')->nullable();
            $table->string('to_city')->nullable();
            $table->string('from_zone')->nullable();
            $table->string('to_zone')->nullable();
            $table->string('area_name')->nullable(); // For area-wise rates
            $table->decimal('rate_per_kg', 10, 2)->default(0);
            $table->decimal('rate_per_piece', 10, 2)->default(0);
            $table->decimal('minimum_charge', 10, 2)->default(0);
            $table->string('vehicle_type')->nullable();
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('party_type');
            $table->index('party_code');
            $table->index(['from_city', 'to_city']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_area_rates');
    }
};
