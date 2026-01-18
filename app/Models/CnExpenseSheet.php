<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CnExpenseSheet extends Model
{
    use HasFactory;

    protected $primaryKey = 'expense_sheet_id';
    public $incrementing = true;

    protected $fillable = [
        'sheet_number',
        'system_year',
        'expense_date',
        'shipment_id',
        'expense_type',
        'expense_category',
        'amount',
        'vendor_name',
        'description',
        'payment_mode',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
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
