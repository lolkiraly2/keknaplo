<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ],
        [
            'name.required' => 'A név megadása kötelező!',
            'email.required' => 'Az email cím megadása kötelező!',
            'email.email' => 'Kérlek adj meg egy érvényes email címet!',
            'email.unique' => 'Ez az email cím már foglalt!',
            'password.required' => 'A jelszó megadása kötelező!',
            'password.confirmed' => 'A két jelszó nem egyezik!',
        ]
    );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        //make folders for user's routes
        Storage::makeDirectory($request->email);
        Storage::makeDirectory( $request->email . '/croutes');
        Storage::makeDirectory($request->email . '/blueroutes');
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
