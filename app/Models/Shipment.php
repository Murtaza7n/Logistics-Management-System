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
        'customer_id',
        'vendor_id',
        'sender',
        'receiver',
        'sender_contact',
        'receiver_contact',
        'pickup_city',
        'delivery_city',
        'pickup_address',
        'delivery_address',
        'cargo_type',
        'weight',
        'dimension',
        'quantity',
        'freight_charges',
        'labor_charges',
        'other_charges',
        'status',
        'vehicle_id',
        'driver_id',
        'pickup_date',
        'delivery_date',
        'actual_delivery_date',
        'notes',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'freight_charges' => 'decimal:2',
        'labor_charges' => 'decimal:2',
        'other_charges' => 'decimal:2',
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


