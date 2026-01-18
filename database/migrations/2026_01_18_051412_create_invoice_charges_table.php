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
        Schema::create('invoice_charges', function (Blueprint $table) {
            $table->id();
            $table->string('charge_code')->unique();
            $table->string('charge_name');
            $table->string('charge_type')->nullable(); // freight, labor, fuel, other
            $table->enum('calculation_type', ['fixed', 'per_kg', 'per_piece', 'percentage'])->default('fixed');
            $table->decimal('rate', 10, 2)->default(0);
            $table->boolean('is_taxable')->default(false);
            $table->decimal('tax_rate', 5, 2)->default(0); // percentage
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('charge_code');
            $table->index('charge_type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_charges');
    }
};
