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
        Schema::create('vehicle_load_plan_shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('load_plan_id')->constrained('vehicle_load_plans', 'load_plan_id')->onDelete('cascade');
            $table->foreignId('shipment_id')->constrained('shipments', 'shipment_id')->onDelete('cascade');
            $table->integer('sequence')->default(0);
            $table->enum('status', ['loaded', 'in-transit', 'delivered', 'returned'])->default('loaded');
            $table->timestamps();
            $table->unique(['load_plan_id', 'shipment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_load_plan_shipments');
    }
};
