<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'status',
        'user_agent',
        'login_at',
    ];

    protected function casts(): array
    {
        return [
            'login_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
