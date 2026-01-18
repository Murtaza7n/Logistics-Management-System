<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'size_code',
        'size_name',
        'length',
        'width',
        'height',
        'max_weight',
        'max_volume',
        'description',
        'is_active',
    ];

    protected $casts = [
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'max_weight' => 'decimal:2',
        'max_volume' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
