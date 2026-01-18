<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'item_name',
        'description',
        'category',
        'unit_price',
        'unit',
        'is_active',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
