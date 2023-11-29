<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AuthController extends Controller
{
    public function show()
    {
        return View::make('Login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('Main');
        }

        return back()->withErrors([
            'credential' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        // Invalidate the session
        auth()->logout();
        $request->session()->invalidate();
        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('Main');
    }
}
