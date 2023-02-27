<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function create()
    {
        return inertia('Auth/Login');
    }

    public function store(Request $request)
    {
        if (!Auth::attempt(
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]),
            true
        )) {
            throw ValidationException::withMessages([
                'email' => 'Authentication failed'
                // never give detail information about error
                // authentication failed is just enough
                // attacker may know what is wrong , ex : email or password
            ]);
        };

        // regenarate = attacker may steal link ID 
        // after authenticated generate session ID
        $request->session()->regenerate();

        // intended page = redirected to login page or listing
        // handled by laravel
        return redirect()->intended('/listing');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('listing.index');
    }
}
