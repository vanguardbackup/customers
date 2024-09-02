<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Command to expire support time purchases older than one year.
 *
 * This command processes users in chunks, expiring their support time purchases
 * that are over a year old and updating their support time balance accordingly.
 */
class ExpireSupportTimeCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'support:expire-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire support time that is over a year old';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting support time expiration process...');

        $oneYearAgo = Carbon::now()->subYear();

        User::chunk(100, function ($users) use ($oneYearAgo) {
            foreach ($users as $user) {
                $this->expireUserSupportTime($user, $oneYearAgo);
            }
        });

        $this->info('Support time expiration process completed.');
    }

    /**
     * Expire support time for a single user.
     *
     * @param  User  $user  The user to process
     * @param  Carbon  $oneYearAgo  The cutoff date for expiring purchases
     */
    private function expireUserSupportTime(User $user, Carbon $oneYearAgo): void
    {
        DB::transaction(function () use ($user, $oneYearAgo) {
            $expiredPurchases = $this->getExpiredPurchases($user, $oneYearAgo);
            $totalExpiredTime = $this->expirePurchases($expiredPurchases);

            if ($totalExpiredTime > 0) {
                $this->updateUserSupportTimeBalance($user, $totalExpiredTime);
            }
        });
    }

    /**
     * Get expired support time purchases for a user.
     *
     * @param  User  $user  The user to get purchases for
     * @param  Carbon  $oneYearAgo  The cutoff date for expired purchases
     * @return Collection The collection of expired purchases
     */
    private function getExpiredPurchases(User $user, Carbon $oneYearAgo): Collection
    {
        return $user->supportTimePurchases()
            ->where('created_at', '<', $oneYearAgo)
            ->whereNull('expired_at')
            ->get();
    }

    /**
     * Expire the given purchases and calculate total expired time.
     *
     * @param  Collection  $purchases  The purchases to expire
     * @return int The total amount of time expired
     */
    private function expirePurchases(Collection $purchases): int
    {
        $totalExpiredTime = 0;

        foreach ($purchases as $purchase) {
            $totalExpiredTime += $purchase->quantity;
            $purchase->expired_at = Carbon::now();
            $purchase->save();
        }

        return $totalExpiredTime;
    }

    /**
     * Update the user's support time balance after expiring time.
     *
     * @param  User  $user  The user to update
     * @param  int  $expiredTime  The amount of time to deduct from the user's balance
     */
    private function updateUserSupportTimeBalance(User $user, int $expiredTime): void
    {
        $user->support_time_balance = max(0, $user->support_time_balance - $expiredTime);
        $user->save();

        $this->info("Expired {$expiredTime} hours for user {$user->id}");
    }
}
