<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyFuelRate extends Model
{
    use HasFactory;

    protected $primaryKey = 'fuel_rate_id';
    public $incrementing = true;

    protected $fillable = [
        'party_type',
        'party_id',
        'party_code',
        'party_name',
        'from_city',
        'to_city',
        'fuel_rate',
        'vehicle_type',
        'effective_from',
        'effective_to',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'fuel_rate' => 'decimal:2',
        'effective_from' => 'date',
        'effective_to' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
