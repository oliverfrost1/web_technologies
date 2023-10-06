<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function show() {
        return View::make("Login");
    }

    public function authenticate(Request $request): RedirectResponse {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
{
    Auth::logout();  // Invalidate the session
    $request->session()->invalidate();  // Invalidate the session
    $request->session()->regenerateToken();  // Regenerate CSRF token

    return redirect('/');  // Redirect to homepage
}
}