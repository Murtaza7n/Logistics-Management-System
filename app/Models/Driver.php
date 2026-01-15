<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $primaryKey = 'driver_id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'license_no',
        'contact',
        'email',
        'address',
        'assigned_vehicle',
        'license_expiry',
        'status',
    ];

    protected $casts = [
        'license_expiry' => 'date',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'assigned_vehicle');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'driver_id');
    }
}


