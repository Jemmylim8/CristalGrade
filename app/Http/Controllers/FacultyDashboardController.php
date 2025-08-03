<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;

class FacultyDashboardController extends Controller
{
    public function index()
    {
        $classes = ClassModel::where('faculty_id', auth()->id())->get();
        return view('dashboards.faculty', compact('classes'));
    }
}
