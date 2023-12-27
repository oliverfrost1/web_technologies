<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            // print to console
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
    }

    public function logout(Request $request)
    {
        // Invalidate the session
        auth()->logout();
        $request->session()->invalidate();
        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect()->route('main');
    }
}
