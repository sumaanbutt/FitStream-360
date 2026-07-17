<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSession extends Model
{
    protected $fillable = [
        'session_code',
        'user_code',
        'ip_address',
        'user_agent',
        'last_activity',
        'expires_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'last_activity' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_code',
            'code'
        );
    }
}
