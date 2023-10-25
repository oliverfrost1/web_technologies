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
            'new_password' => 'nullable|min:8',
            'confirm_new_password' => 'nullable|same:new_password',
        ]);

        $dataChanged = false;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
            $dataChanged = true;
        }

        if ($request->input('name') !== $user->name) {
            $user->name = $request->input('name');
            $dataChanged = true;
        }

        if ($request->input('email') !== $user->email) {
            $user->email = $request->input('email');
            $dataChanged = true;
        }

        if (!$dataChanged) {
            return redirect()->back()->with('info', 'Nothing to update');
        }

        if ($request->filled('current_password') && !Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }


}
