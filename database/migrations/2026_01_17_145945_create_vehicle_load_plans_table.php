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
        Schema::create('vehicle_load_plans', function (Blueprint $table) {
            $table->id('load_plan_id');
            $table->string('plan_number')->unique();
            $table->string('system_year')->default('2526');
            $table->date('plan_date');
            $table->foreignId('vehicle_id')->constrained('vehicles', 'vehicle_id')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('drivers', 'driver_id')->onDelete('set null');
            $table->string('from_city');
            $table->string('to_city');
            $table->date('planned_departure_date')->nullable();
            $table->date('planned_arrival_date')->nullable();
            $table->date('actual_departure_date')->nullable();
            $table->date('actual_arrival_date')->nullable();
            $table->enum('status', ['planned', 'in-transit', 'received', 'completed', 'cancelled'])->default('planned');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('plan_number');
            $table->index('system_year');
            $table->index('plan_date');
            $table->index('vehicle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_load_plans');
    }
};
