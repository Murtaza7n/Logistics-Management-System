<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $primaryKey = 'shipment_id';
    public $incrementing = true;

    protected $fillable = [
        'shipment_number',
        'system_year',
        'cn_book_id',
        'customer_id',
        'vendor_id',
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
        'sender',
        'receiver',
        'sender_contact',
        'receiver_contact',
        'pickup_city',
        'delivery_city',
        'pickup_address',
        'delivery_address',
        'cargo_type',
        'cn_type',
        'weight',
        'dimension',
        'quantity',
        'packages',
        'packaging_type',
        'freight_charges',
        'labor_charges',
        'other_charges',
        'declared_value',
        'payment_mode',
        'delivery_type',
        'status',
        'vehicle_id',
        'driver_id',
        'pickup_date',
        'delivery_date',
        'actual_delivery_date',
        'notes',
        'special_instructions',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'packages' => 'decimal:2',
        'freight_charges' => 'decimal:2',
        'labor_charges' => 'decimal:2',
        'other_charges' => 'decimal:2',
        'declared_value' => 'decimal:2',
        'pickup_date' => 'date',
        'delivery_date' => 'date',
        'actual_delivery_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function entryCity()
    {
        return $this->belongsTo(City::class, 'entry_city', 'city_id');
    }

    /**
     * Get the CN number usage record for this shipment
     */
    public function cnNumberUsage()
    {
        return $this->hasOne(CNNumberUsage::class, 'shipment_id', 'shipment_id');
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_shipments', 'shipment_id', 'invoice_id')
                    ->withPivot('amount')
                    ->withTimestamps();
    }

    public function getTotalChargesAttribute()
    {
        return $this->freight_charges + $this->labor_charges + $this->other_charges;
    }
}


