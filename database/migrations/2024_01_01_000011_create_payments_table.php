<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('invoice_id')->constrained('invoices', 'invoice_id')->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date');
            $table->enum('method', ['cash', 'bank_transfer', 'cheque', 'credit_card', 'other'])->default('cash');
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};


