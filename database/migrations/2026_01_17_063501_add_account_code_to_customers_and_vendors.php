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
        Schema::table('customers', function (Blueprint $table) {
            $table->string('account_code')->unique()->nullable()->after('customer_id');
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->string('account_code')->unique()->nullable()->after('vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('account_code');
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('account_code');
        });
    }
};
