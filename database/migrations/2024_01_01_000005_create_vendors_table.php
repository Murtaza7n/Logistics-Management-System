<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id('vendor_id');
            $table->string('name');
            $table->text('services')->nullable(); // Services provided
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('billing_terms')->nullable(); // Net 30, Net 60, etc.
            $table->string('tax_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};


