<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ],
        [
            'current_password.required' => 'A jelszó megadása kötelező.',
            'current_password.current_password' => 'A megadott jelszó helytelen.',
            'password.required' => 'A jelszó megadása kötelező.',
            'password.confirmed' => 'A két jelszó nem egyezik.',
            'password.min' => 'A jelszónak legalább :min karakter hosszúnak kell lennie.',
        ]
    );

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back();
    }
}
