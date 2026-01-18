<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoOfficer extends Model
{
    use HasFactory;

    protected $fillable = [
        'officer_code',
        'officer_name',
        'designation',
        'employee_id',
        'contact_number',
        'email',
        'city',
        'hub',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
