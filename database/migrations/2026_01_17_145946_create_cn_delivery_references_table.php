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
        Schema::create('cn_delivery_references', function (Blueprint $table) {
            $table->id('reference_id');
            $table->foreignId('shipment_id')->constrained('shipments', 'shipment_id')->onDelete('cascade');
            $table->string('reference_number')->unique();
            $table->string('reference_type')->nullable(); // POD, Delivery Note, etc.
            $table->date('reference_date')->nullable();
            $table->string('delivered_by')->nullable();
            $table->string('received_by')->nullable();
            $table->text('delivery_address')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('reference_number');
            $table->index('shipment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cn_delivery_references');
    }
};
