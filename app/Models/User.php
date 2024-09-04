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

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'billing_address' => 'encrypted',
        'billing_city' => 'encrypted',
        'billing_state' => 'encrypted',
        'billing_country' => 'encrypted',
        'billing_zip_code' => 'encrypted',
    ];

    /**
     * Get the user's Gravatar URL.
     */
    public function getGravatarAttribute(): string
    {
        $hash = md5(strtolower(trim($this->email)));

        return "https://www.gravatar.com/avatar/{$hash}";
    }

    /**
     * Get the user's support time purchases.
     */
    public function supportTimePurchases(): HasMany
    {
        return $this->hasMany(SupportTimePurchase::class);
    }

    /**
     * Get the user's current support time balance.
     */
    public function getSupportTimeBalanceAttribute(): int
    {
        return $this->supportTimePurchases()
            ->active()
            ->sum('quantity');
    }

    /**
     * Scope to include the support time balance.
     */
    public function scopeWithSupportTimeBalance($query)
    {
        return $query->withSum('supportTimePurchases as support_time_balance', 'quantity');
    }

    /**
     * Deduct time from the user's support time balance.
     */
    public function deductSupportTime(int $timeToDeduct): void
    {
        $purchases = $this->supportTimePurchases()
            ->active()
            ->orderBy('created_at')
            ->get();

        foreach ($purchases as $purchase) {
            if ($timeToDeduct <= 0) {
                break;
            }

            if ($purchase->quantity <= $timeToDeduct) {
                $timeToDeduct -= $purchase->quantity;
                $purchase->expire();
            } else {
                $purchase->decrement('quantity', $timeToDeduct);
                $timeToDeduct = 0;
            }
        }
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->email === config('app.admin_email');
    }
}
