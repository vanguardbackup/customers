<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Handles user profile management operations.
 */
class ProfileController extends Controller
{
    /**
     * Display the user's profile edit form.
     */
    public function edit(): View
    {
        return view('user.profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $validated = $request->validated();

        $this->updateUserProfile($user, $validated);

        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Profile updated successfully!');
    }

    /**
     * Update user profile with validated data.
     */
    private function updateUserProfile($user, array $data): void
    {
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'billing_address' => $data['billing_address'],
            'billing_city' => $data['billing_city'],
            'billing_state' => $data['billing_state'],
            'billing_country' => $data['billing_country'],
            'billing_zip_code' => $data['billing_zip_code'],
        ]);
    }
}
