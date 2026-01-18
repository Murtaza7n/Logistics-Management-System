<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleLoadPlan extends Model
{
    use HasFactory;

    protected $primaryKey = 'load_plan_id';
    public $incrementing = true;

    protected $fillable = [
        'plan_number',
        'system_year',
        'plan_date',
        'vehicle_id',
        'driver_id',
        'from_city',
        'to_city',
        'planned_departure_date',
        'planned_arrival_date',
        'actual_departure_date',
        'actual_arrival_date',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'plan_date' => 'date',
        'planned_departure_date' => 'date',
        'planned_arrival_date' => 'date',
        'actual_departure_date' => 'date',
        'actual_arrival_date' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class, 'vehicle_load_plan_shipments', 'load_plan_id', 'shipment_id')
            ->withPivot('sequence', 'status')
            ->withTimestamps();
    }
}
