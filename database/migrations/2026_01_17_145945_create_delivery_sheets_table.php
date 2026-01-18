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
        Schema::create('delivery_sheets', function (Blueprint $table) {
            $table->id('delivery_sheet_id');
            $table->string('sheet_number')->unique();
            $table->string('system_year')->default('2526');
            $table->date('sheet_date');
            $table->foreignId('driver_id')->nullable()->constrained('drivers', 'driver_id')->onDelete('set null');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles', 'vehicle_id')->onDelete('set null');
            $table->string('delivery_city');
            $table->date('delivery_date');
            $table->enum('status', ['prepared', 'out-for-delivery', 'completed', 'cancelled'])->default('prepared');
            $table->integer('total_shipments')->default(0);
            $table->integer('delivered_count')->default(0);
            $table->integer('pending_count')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('sheet_number');
            $table->index('system_year');
            $table->index('sheet_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_sheets');
    }
};
