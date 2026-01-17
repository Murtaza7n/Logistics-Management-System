<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizedLeave extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_type',
        'total_leaves',
        'used_leaves',
        'remaining_leaves',
        'year',
        'notes',
    ];

    protected $casts = [
        'total_leaves' => 'integer',
        'used_leaves' => 'integer',
        'remaining_leaves' => 'integer',
        'year' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'emp_id');
    }
}

