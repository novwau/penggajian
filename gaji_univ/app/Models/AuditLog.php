<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

