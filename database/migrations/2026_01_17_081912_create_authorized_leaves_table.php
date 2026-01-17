<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authorized_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('leave_type'); // e.g., 'Annual', 'Sick', 'Casual', 'Unpaid'
            $table->integer('total_leaves');
            $table->integer('used_leaves')->default(0);
            $table->integer('remaining_leaves');
            $table->integer('year');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('employee_id')->references('emp_id')->on('employees')->onDelete('cascade');
            $table->unique(['employee_id', 'leave_type', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorized_leaves');
    }
};
