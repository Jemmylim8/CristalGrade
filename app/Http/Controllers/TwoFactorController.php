<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.two-factor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|integer',
        ]);

        $user = auth()->user();

        if ($request->two_factor_code == $user->two_factor_code) {
            $user->resetTwoFactorCode(); // clear code after success
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors([
            'two_factor_code' => 'The code you entered is incorrect.',
        ]);
    }
}
