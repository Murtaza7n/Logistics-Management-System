<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartyAreaRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_type',
        'party_code',
        'party_name',
        'from_city',
        'to_city',
        'from_zone',
        'to_zone',
        'area_name',
        'rate_per_kg',
        'rate_per_piece',
        'minimum_charge',
        'vehicle_type',
        'effective_from',
        'effective_to',
        'is_active',
    ];

    protected $casts = [
        'rate_per_kg' => 'decimal:2',
        'rate_per_piece' => 'decimal:2',
        'minimum_charge' => 'decimal:2',
        'effective_from' => 'date',
        'effective_to' => 'date',
        'is_active' => 'boolean',
    ];
}
