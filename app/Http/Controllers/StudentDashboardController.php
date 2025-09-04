<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Load classes the student joined + their faculty to avoid N+1 queries
        $classes = auth()->user()
            ->classes()
            ->with('faculty')
            ->orderBy('year_level')
            ->get();

        return view('dashboards.student', compact('classes'));
    }
}
