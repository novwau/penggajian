<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollPeriod extends Model
{
    protected $fillable = [
        'nama',
        'start_date',
        'end_date',
        'status',
    ];

    // App\Models\PayrollPeriod.php
protected $casts = [
    'start_date' => 'date',
    'end_date'   => 'date',
];


    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
