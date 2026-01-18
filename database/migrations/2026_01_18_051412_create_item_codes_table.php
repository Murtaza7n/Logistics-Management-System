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
        Schema::create('item_codes', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->string('unit')->nullable(); // kg, piece, box, etc.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('item_code');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_codes');
    }
};
