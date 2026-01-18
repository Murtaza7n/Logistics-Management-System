<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'zone_code',
        'zone_name',
        'city',
        'state',
        'description',
        'base_rate',
        'is_active',
    ];

    protected $casts = [
        'base_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
