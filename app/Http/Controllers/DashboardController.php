<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('dashboards.admin');
        } elseif ($user->role === 'faculty') {
            return view('dashboards.faculty');
        } else {
            return view('dashboards.student');
        }
    }
}
