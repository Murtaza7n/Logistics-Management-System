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
        Schema::table('shipments', function (Blueprint $table) {
            // Add CN Entry specific fields
            $table->string('entry_city')->nullable()->after('pickup_city');
            $table->string('shipper_code')->nullable()->after('customer_id');
            $table->string('shipper_name')->nullable()->after('shipper_code');
            $table->text('shipper_address_line1')->nullable()->after('shipper_name');
            $table->text('shipper_address_line2')->nullable()->after('shipper_address_line1');
            $table->text('shipper_address_line3')->nullable()->after('shipper_address_line2');
            $table->string('shipper_contact')->nullable()->after('shipper_address_line3');
            $table->string('consignee_code')->nullable()->after('vendor_id');
            $table->string('consignee_name')->nullable()->after('consignee_code');
            $table->text('consignee_address_line1')->nullable()->after('consignee_name');
            $table->text('consignee_address_line2')->nullable()->after('consignee_address_line1');
            $table->text('consignee_address_line3')->nullable()->after('consignee_address_line2');
            $table->string('consignee_contact')->nullable()->after('consignee_address_line3');
            $table->string('cn_type')->nullable()->after('cargo_type'); // C field - type of CN
            $table->decimal('packages', 10, 2)->nullable()->after('quantity');
            $table->string('packaging_type')->nullable()->after('packages'); // Box, Carton, Bag, etc.
            $table->decimal('declared_value', 12, 2)->nullable()->after('other_charges');
            $table->string('payment_mode')->nullable()->after('declared_value'); // To Pay, Paid, etc.
            $table->string('delivery_type')->nullable()->after('payment_mode'); // Door Delivery, Self Pickup, etc.
            $table->text('special_instructions')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn([
                'entry_city',
                'shipper_code',
                'shipper_name',
                'shipper_address_line1',
                'shipper_address_line2',
                'shipper_address_line3',
                'shipper_contact',
                'consignee_code',
                'consignee_name',
                'consignee_address_line1',
                'consignee_address_line2',
                'consignee_address_line3',
                'consignee_contact',
                'cn_type',
                'packages',
                'packaging_type',
                'declared_value',
                'payment_mode',
                'delivery_type',
                'special_instructions',
            ]);
        });
    }
};
