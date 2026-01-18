<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'charge_code',
        'charge_name',
        'charge_type',
        'calculation_type',
        'rate',
        'is_taxable',
        'tax_rate',
        'description',
        'is_active',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'is_taxable' => 'boolean',
        'is_active' => 'boolean',
    ];
}
