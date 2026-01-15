<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $primaryKey = 'payroll_id';
    public $incrementing = true;

    protected $fillable = [
        'emp_id',
        'month',
        'basic_salary',
        'overtime',
        'bonus',
        'deductions',
        'deduction_details',
        'net_salary',
        'status',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'overtime' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}


