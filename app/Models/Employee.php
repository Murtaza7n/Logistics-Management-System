<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $primaryKey = 'emp_id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'role',
        'contact',
        'email',
        'address',
        'bank_account',
        'bank_name',
        'hire_date',
        'status',
        'department_id',
        'designation_id',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'emp_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'employee_id', 'emp_id');
    }

    public function monthlyDeductionsAllowances()
    {
        return $this->hasMany(MonthlyDeductionAllowance::class, 'employee_id', 'emp_id');
    }

    public function authorizedLeaves()
    {
        return $this->hasMany(AuthorizedLeave::class, 'employee_id', 'emp_id');
    }

    public function getLatestPayrollAttribute()
    {
        return $this->payrolls()->latest('month')->first();
    }
}


