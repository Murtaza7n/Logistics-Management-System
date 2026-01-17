<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cn_number_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('system_year')->default('2526');
            $table->string('city_code')->nullable();
            $table->integer('last_number')->default(0);
            $table->string('prefix')->default('CN');
            $table->string('format')->default('CN-{YEAR}-{NUMBER}'); // CN-2526-00001
            $table->timestamps();
            
            $table->unique(['system_year', 'city_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cn_number_sequences');
    }
};

