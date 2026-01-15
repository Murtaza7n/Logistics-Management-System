<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'contact',
        'email',
        'address',
        'city',
        'state',
        'country',
        'tax_id',
        'status',
    ];

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'customer_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'customer_id');
    }
}


