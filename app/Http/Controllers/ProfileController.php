<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        $validationMessage = $this->validateInput($request, $user);
        $shouldUpdate = $this->shouldUpdate($request, $user);

        if ($validationMessage) {
            return back()->withErrors($validationMessage);
        }

        if (! $shouldUpdate) {
            return back()->with('info', 'Nothing to update');
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }

    public function getProfilePage()
    {
        return view('profile');
    }

    private function shouldUpdate(Request $request, $user)
    {
        $dataChanged = false;

        if ($this->isNameChanged($request, $user)) {
            $user->name = $request->input('name');
            $dataChanged = true;
        }

        if ($this->isEmailChanged($request, $user)) {
            $user->email = $request->input('email');
            $dataChanged = true;
        }

        if ($this->isPasswordChanged($request, $user)) {
            $user->password = Hash::make($request->input('new_password'));
            $dataChanged = true;
        }

        return $dataChanged;
    }

    private function validateInput(Request $request, $user)
    {
        $validator = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:8',
            'confirm_new_password' => 'nullable|same:new_password',
        ]);

        if (! $this->isCurrentPasswordValid($request, $user)) {
            return ['current_password' => 'Current password is incorrect'];
        }

        return null;
    }

    private function isCurrentPasswordValid(Request $request, $user)
    {
        if ($request->filled('current_password')) {
            return Hash::check($request->input('current_password'), $user->password);
        }
    }

    private function isNameChanged(Request $request, $user)
    {
        return $request->input('name') !== $user->name;
    }

    private function isEmailChanged(Request $request, $user)
    {
        return $request->input('email') !== $user->email;
    }

    private function isPasswordChanged(Request $request, $user)
    {
        return $request->filled('new_password') && $request->filled('current_password');
    }
}
