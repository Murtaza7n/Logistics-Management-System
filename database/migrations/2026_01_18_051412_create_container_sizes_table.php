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
        Schema::create('container_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size_code')->unique(); // e.g., "20FT", "40FT", "LCL"
            $table->string('size_name'); // e.g., "20 Feet Container"
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('max_weight', 10, 2)->nullable(); // in kg
            $table->decimal('max_volume', 10, 2)->nullable(); // in cubic meters
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('size_code');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container_sizes');
    }
};
