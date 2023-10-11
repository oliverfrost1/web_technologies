<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TopBar extends Component
{
    public function render()
    {
        return view('components.top-bar');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
     
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}