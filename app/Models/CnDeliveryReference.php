<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnDeliveryReference extends Model
{
    use HasFactory;

    protected $primaryKey = 'reference_id';
    public $incrementing = true;

    protected $fillable = [
        'shipment_id',
        'reference_number',
        'reference_type',
        'reference_date',
        'delivered_by',
        'received_by',
        'delivery_address',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'reference_date' => 'date',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
