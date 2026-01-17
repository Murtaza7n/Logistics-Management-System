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
        Schema::create('user_city_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities', 'city_id')->onDelete('cascade');
            
            // Module permissions (JSON field for flexibility)
            // Structure: {"shipments": ["view", "create", "edit", "delete"], "reports": ["view"], ...}
            $table->json('permissions')->nullable();
            
            // Quick access flags
            $table->boolean('can_view')->default(true);
            $table->boolean('can_create')->default(false);
            $table->boolean('can_edit')->default(false);
            $table->boolean('can_delete')->default(false);
            
            $table->timestamps();
            
            // Unique constraint: one permission record per user-city combination
            $table->unique(['user_id', 'city_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_city_permissions');
    }
};
