<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Handles the main dashboard functionality for authenticated users.
 */
class HomeController extends Controller
{
    /**
     * Display the user's dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $supportTimePurchases = $user->supportTimePurchases()->latest()->get();

        return view('user.home', [
            'user' => $request->user(),
            'supportTimePurchases' => $supportTimePurchases,
        ]);
    }
}
