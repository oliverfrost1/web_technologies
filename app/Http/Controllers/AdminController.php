<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view::make('AdminDashboard', ['users' => $this->getAllUsers()]);
    }
    public function editUserForm($id)
    {
        $user = User::findOrFail($id);

        return view::make('AdminEditUser', ['user' => $user]);
    }

    public function editUser(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ];

        $validatedData = $request->validate($rules);
        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if ($validatedData['password']) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->save();

        return redirect()->route('admin.dashboard');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User has been deleted successfully');
    }

    private function getAllUsers()
    {
        return User::all();
    }
}
