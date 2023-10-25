<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|min:8',
            'new_password' => 'nullable|same:confirm_new_password|min:8',
            'confirm_new_password' => 'nullable|same:new_password',
        ]);

        $dataChanged = false;

        if ($request->filled('current_password') && !Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect',
            ]);
        }

        if ($request->input('name') !== $user->name) {
            $user->name = $request->input('name');
            $dataChanged = true;
        }

        if ($request->input('email') !== $user->email) {
            $user->email = $request->input('email');
            $dataChanged = true;
        }

        if ($request->filled('new_password') && $request->filled('current_password')) {
            $user->password = Hash::make($request->input('new_password'));
            $dataChanged = true;
        } else {
            return back()->withErrors([
                'current_password' => 'Current password is required for updating password',
            ]);
        }

        if (!$dataChanged) {
            return back()->with('info', 'Nothing to update');
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');

    }


}
