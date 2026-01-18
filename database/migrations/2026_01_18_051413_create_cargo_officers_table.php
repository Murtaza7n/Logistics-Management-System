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
        Schema::create('cargo_officers', function (Blueprint $table) {
            $table->id();
            $table->string('officer_code')->unique();
            $table->string('officer_name');
            $table->string('designation')->nullable(); // SPO, Cargo Officer, etc.
            $table->string('employee_id')->nullable(); // Link to employees table if exists
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('hub')->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('officer_code');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_officers');
    }
};
