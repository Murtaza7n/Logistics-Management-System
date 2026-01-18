<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupSheet extends Model
{
    use HasFactory;

    protected $primaryKey = 'pickup_sheet_id';
    public $incrementing = true;

    protected $fillable = [
        'sheet_number',
        'system_year',
        'sheet_date',
        'driver_id',
        'vehicle_id',
        'pickup_city',
        'pickup_date',
        'status',
        'total_bookings',
        'picked_up_count',
        'pending_count',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'sheet_date' => 'date',
        'pickup_date' => 'date',
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

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'pickup_sheet_bookings', 'pickup_sheet_id', 'booking_id')
            ->withPivot('sequence', 'pickup_status', 'pickup_time', 'notes')
            ->withTimestamps();
    }
}
