<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $primaryKey = 'booking_id';
    public $incrementing = true;

    protected $fillable = [
        'booking_number',
        'system_year',
        'booking_date',
        'customer_id',
        'vendor_id',
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
        'pickup_city',
        'delivery_city',
        'cargo_type',
        'weight',
        'quantity',
        'estimated_freight',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'estimated_freight' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'booking_id', 'booking_id');
    }
}
