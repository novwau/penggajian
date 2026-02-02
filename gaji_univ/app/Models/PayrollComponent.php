<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayrollComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',            // income / deduction
        'calculation_type', // fixed / daily / percent
        'value',
    ];

    /**
     * Users yang punya komponen ini
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_payroll_components')
                    ->withPivot('value')
                    ->withTimestamps();
    }
}
