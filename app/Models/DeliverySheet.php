<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySheet extends Model
{
    use HasFactory;

    protected $primaryKey = 'delivery_sheet_id';
    public $incrementing = true;

    protected $fillable = [
        'sheet_number',
        'system_year',
        'sheet_date',
        'driver_id',
        'vehicle_id',
        'delivery_city',
        'delivery_date',
        'status',
        'total_shipments',
        'delivered_count',
        'pending_count',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'sheet_date' => 'date',
        'delivery_date' => 'date',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class, 'delivery_sheet_shipments', 'delivery_sheet_id', 'shipment_id')
            ->withPivot('sequence', 'delivery_status', 'delivery_time', 'received_by', 'notes')
            ->withTimestamps();
    }
}
