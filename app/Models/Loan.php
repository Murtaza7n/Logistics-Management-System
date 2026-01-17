<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'loan_type',
        'loan_amount',
        'interest_rate',
        'installment_amount',
        'total_installments',
        'paid_installments',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'loan_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'total_installments' => 'integer',
        'paid_installments' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'emp_id');
    }
}

