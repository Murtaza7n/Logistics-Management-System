<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $primaryKey = 'vehicle_id';
    public $incrementing = true;

    protected $fillable = [
        'type',
        'registration_no',
        'make',
        'model',
        'year',
        'capacity',
        'status',
        'purchase_date',
        'notes',
    ];

    protected $casts = [
        'capacity' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    public function driver()
    {
        return $this->hasOne(Driver::class, 'assigned_vehicle');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'vehicle_id');
    }
}


