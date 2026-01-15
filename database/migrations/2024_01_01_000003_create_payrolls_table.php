<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id('payroll_id');
            $table->foreignId('emp_id')->constrained('employees', 'emp_id')->onDelete('cascade');
            $table->string('month'); // Format: YYYY-MM
            $table->decimal('basic_salary', 10, 2)->default(0);
            $table->decimal('overtime', 10, 2)->default(0);
            $table->decimal('bonus', 10, 2)->default(0);
            $table->decimal('deductions', 10, 2)->default(0);
            $table->text('deduction_details')->nullable();
            $table->decimal('net_salary', 10, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->date('payment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['emp_id', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};


