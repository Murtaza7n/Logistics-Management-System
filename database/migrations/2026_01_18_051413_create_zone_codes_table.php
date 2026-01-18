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
        Schema::create('zone_codes', function (Blueprint $table) {
            $table->id();
            $table->string('zone_code')->unique();
            $table->string('zone_name');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('description')->nullable();
            $table->decimal('base_rate', 10, 2)->nullable(); // Base freight rate for this zone
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('zone_code');
            $table->index('city');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zone_codes');
    }
};
