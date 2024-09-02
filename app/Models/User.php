<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Represents a user in the application.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'billing_address' => 'encrypted',
        'billing_city' => 'encrypted',
        'billing_state' => 'encrypted',
        'billing_country' => 'encrypted',
        'billing_zip_code' => 'encrypted',
        'support_time_balance' => 'integer',
    ];

    /**
     * Get the user's Gravatar URL.
     */
    public function getGravatarAttribute(): string
    {
        $hash = md5(strtolower(trim($this->email)));

        return "https://www.gravatar.com/avatar/{$hash}";
    }

    public function supportTimePurchases(): HasMany
    {
        return $this->hasMany(SupportTimePurchase::class);
    }
}
