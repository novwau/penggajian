<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PayrollPeriod;

class Payroll extends Model
{
    protected $fillable = [
        'user_id',
        'payroll_period_id',
        'total_income',
        'total_deduction',
        'net_salary',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function period()
    {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id');
    }

    public function details()
{
    return $this->hasMany(PayrollDetail::class, 'payroll_id'); 
}

}
