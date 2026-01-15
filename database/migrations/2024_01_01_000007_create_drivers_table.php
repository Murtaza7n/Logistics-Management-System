<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('driver_id');
            $table->string('name');
            $table->string('license_no')->unique();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('assigned_vehicle')->nullable()->constrained('vehicles', 'vehicle_id')->onDelete('set null');
            $table->date('license_expiry')->nullable();
            $table->enum('status', ['available', 'on-trip', 'off-duty', 'suspended'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};


