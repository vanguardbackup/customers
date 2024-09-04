<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeductTimeController extends Controller
{
    /**
     * Display a list of users with their support time balance.
     */
    public function index(Request $request): View
    {
        $query = User::query()->withSupportTimeBalance();

        if ($request->filled('search')) {
            $query->where(function (Builder $q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('balance_filter')) {
            $query->when($request->balance_filter === 'with_balance', function (Builder $q) {
                $q->has('supportTimePurchases', '>', 0);
            })->when($request->balance_filter === 'without_balance', function (Builder $q) {
                $q->doesntHave('supportTimePurchases');
            });
        }

        $users = $query->paginate(10)->withQueryString();

        return view('support.deduct-time', [
            'users' => $users,
            'search' => $request->search,
            'balanceFilter' => $request->balance_filter,
        ]);
    }

    /**
     * Deduct time from a user's support time balance.
     */
    public function deductTime(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'time' => 'required|integer|min:1',
        ]);

        $user = User::findOrFail($validatedData['user_id']);
        $timeToDeduct = $validatedData['time'];

        if ($user->support_time_balance < $timeToDeduct) {
            return back()->with('error', 'Insufficient time balance to deduct.');
        }

        $user->deductSupportTime($timeToDeduct);

        return back()->with('success', "Successfully deducted {$timeToDeduct} hours from {$user->name}'s support time balance.");
    }
}
