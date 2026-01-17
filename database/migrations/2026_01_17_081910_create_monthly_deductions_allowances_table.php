<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monthly_deductions_allowances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->integer('month'); // 1-12
            $table->integer('year');
            $table->string('deduction_type')->nullable(); // e.g., 'Tax', 'PF', 'Insurance'
            $table->string('allowance_type')->nullable(); // e.g., 'Transport', 'Medical', 'Housing'
            $table->decimal('deduction_amount', 10, 2)->default(0);
            $table->decimal('allowance_amount', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->foreign('employee_id')->references('emp_id')->on('employees')->onDelete('cascade');
            $table->unique(['employee_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monthly_deductions_allowances');
    }
};
