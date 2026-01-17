<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CNNumberUsage extends Model
{
    use HasFactory;

    protected $table = 'cn_number_usages';

    protected $fillable = [
        'cn_book_id',
        'cn_number',
        'shipment_id',
        'issued_by',
        'issued_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
    ];

    /**
     * Get the CN book this usage belongs to
     */
    public function cnBook()
    {
        return $this->belongsTo(CNBook::class, 'cn_book_id');
    }

    /**
     * Get the shipment this CN number was issued for
     */
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'shipment_id');
    }

    /**
     * Get the user who issued this CN number
     */
    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    /**
     * Scope to get only issued (active) CN numbers
     */
    public function scopeIssued($query)
    {
        return $query->where('status', 'issued');
    }

    /**
     * Scope to get cancelled/voided CN numbers
     */
    public function scopeCancelled($query)
    {
        return $query->whereIn('status', ['cancelled', 'voided']);
    }
}
