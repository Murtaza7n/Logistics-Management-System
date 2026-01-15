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
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'emp_id');
    }

    public function getLatestPayrollAttribute()
    {
        return $this->payrolls()->latest('month')->first();
    }
}


