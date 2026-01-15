<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $primaryKey = 'invoice_id';
    public $incrementing = true;

    protected $fillable = [
        'invoice_number',
        'invoice_type',
        'customer_id',
        'vendor_id',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount',
        'total',
        'status',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class, 'invoice_shipments', 'invoice_id', 'shipment_id')
                    ->withPivot('amount')
                    ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()->sum('amount_paid');
    }

    public function getBalanceAttribute()
    {
        return $this->total - $this->total_paid;
    }

    public function isPaid(): bool
    {
        return $this->balance <= 0;
    }
}


