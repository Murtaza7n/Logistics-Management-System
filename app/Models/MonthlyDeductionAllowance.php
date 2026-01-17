<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyDeductionAllowance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'deduction_type',
        'allowance_type',
        'deduction_amount',
        'allowance_amount',
        'description',
    ];

    protected $casts = [
        'deduction_amount' => 'decimal:2',
        'allowance_amount' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'emp_id');
    }
}

