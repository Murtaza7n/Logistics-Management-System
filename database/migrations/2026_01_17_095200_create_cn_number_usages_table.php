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
        Schema::create('cn_number_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cn_book_id')->constrained('cn_books')->onDelete('cascade');
            $table->string('cn_number'); // The actual CN number issued
            $table->foreignId('shipment_id')->nullable()->constrained('shipments', 'shipment_id')->onDelete('set null');
            $table->foreignId('issued_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('issued_at'); // When the CN number was issued
            $table->enum('status', ['issued', 'cancelled', 'voided'])->default('issued');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Ensure CN number is unique
            $table->unique('cn_number');
            $table->index(['cn_book_id', 'status']);
            $table->index('issued_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cn_number_usages');
    }
};
