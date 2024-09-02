<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'billing_address' => 'encrypted',
            'billing_city' => 'encrypted',
            'billing_state' => 'encrypted',
            'billing_country' => 'encrypted',
            'billing_zip_code' => 'encrypted',
            'support_time_balance' => 'integer',
        ];
    }

    public function getGravatarAttribute(): string
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash";
    }
}
