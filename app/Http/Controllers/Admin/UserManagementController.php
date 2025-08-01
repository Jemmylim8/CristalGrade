<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserManagementController extends Controller
{
    public function create(Request $request)
    {
        $role = $request->query('role');  

        return view('admin.users.create', compact('role'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:faculty,student', // ✅ limit roles
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Trigger email verification for new account
        $user->sendEmailVerificationNotification();

        return redirect()->route('admin.users.create')
            ->with('success', ucfirst($request->role) . ' account created and verification email sent.');
    }
}
