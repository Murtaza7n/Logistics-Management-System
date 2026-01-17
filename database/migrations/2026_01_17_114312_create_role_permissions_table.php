<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role')->unique(); // admin, staff, driver
            $table->json('module_permissions'); // {"cn_entry": true, "reports": true, ...}
            $table->timestamps();
        });

        // Insert default permissions
        DB::table('role_permissions')->insert([
            [
                'role' => 'admin',
                'module_permissions' => json_encode([
                    'cn_entry' => true,
                    'reports' => true,
                    'user_management' => true,
                    'system_settings' => true,
                    'delivery_tracking' => true,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role' => 'staff',
                'module_permissions' => json_encode([
                    'cn_entry' => true,
                    'reports' => true,
                    'user_management' => false,
                    'system_settings' => false,
                    'delivery_tracking' => true,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role' => 'driver',
                'module_permissions' => json_encode([
                    'cn_entry' => false,
                    'reports' => false,
                    'user_management' => false,
                    'system_settings' => false,
                    'delivery_tracking' => true,
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
