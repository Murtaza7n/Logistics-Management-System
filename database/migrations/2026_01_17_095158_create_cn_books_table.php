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
        Schema::create('cn_books', function (Blueprint $table) {
            $table->id();
            $table->string('book_number')->unique(); // e.g., "BOOK-001"
            $table->string('book_name')->nullable(); // Optional descriptive name
            $table->string('city_code')->nullable(); // City code this book belongs to
            $table->string('system_year', 10)->nullable(); // Year this book is for
            $table->integer('start_number'); // Starting CN number in the book
            $table->integer('end_number'); // Ending CN number in the book
            $table->integer('total_numbers'); // Total numbers in book (calculated: end - start + 1)
            $table->integer('issued_count')->default(0); // How many have been issued
            $table->integer('remaining_count')->default(0); // How many remain (calculated)
            $table->enum('status', ['active', 'exhausted', 'archived'])->default('active');
            $table->date('issue_date')->nullable(); // When book was issued/activated
            $table->date('expiry_date')->nullable(); // Optional expiry date
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes for faster lookups
            $table->index(['city_code', 'system_year', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cn_books');
    }
};
