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
        Schema::create('pickup_sheet_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pickup_sheet_id')->constrained('pickup_sheets', 'pickup_sheet_id')->onDelete('cascade');
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id')->onDelete('cascade');
            $table->integer('sequence')->default(0);
            $table->enum('pickup_status', ['pending', 'out-for-pickup', 'picked-up', 'failed', 'cancelled'])->default('pending');
            $table->dateTime('pickup_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['pickup_sheet_id', 'booking_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_sheet_bookings');
    }
};
