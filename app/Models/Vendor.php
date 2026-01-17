<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $primaryKey = 'vendor_id';
    public $incrementing = true;

    protected $fillable = [
        'account_code',
        'name',
        'services',
        'contact',
        'email',
        'address',
        'billing_terms',
        'tax_id',
        'status',
    ];

    public function shipments()
    {
        return $this->hasMany(Shipment::class, 'vendor_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'vendor_id');
    }
}


