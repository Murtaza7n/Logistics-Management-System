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
        Schema::create('cn_expense_sheets', function (Blueprint $table) {
            $table->id('expense_sheet_id');
            $table->string('sheet_number')->unique();
            $table->string('system_year')->default('2526');
            $table->date('expense_date');
            $table->foreignId('shipment_id')->constrained('shipments', 'shipment_id')->onDelete('cascade');
            $table->string('expense_type'); // Fuel, Toll, Labor, Other, etc.
            $table->string('expense_category')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('vendor_name')->nullable();
            $table->text('description')->nullable();
            $table->string('payment_mode')->nullable(); // Cash, Bank, etc.
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('sheet_number');
            $table->index('system_year');
            $table->index('expense_date');
            $table->index('shipment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cn_expense_sheets');
    }
};
