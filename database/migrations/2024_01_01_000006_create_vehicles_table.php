<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicle_id');
            $table->string('type'); // Truck, Van, Container, etc.
            $table->string('registration_no')->unique();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->decimal('capacity', 8, 2)->nullable(); // Weight capacity in kg
            $table->enum('status', ['available', 'in-use', 'maintenance', 'retired'])->default('available');
            $table->date('purchase_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};


