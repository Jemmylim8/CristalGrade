<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassModel; // ✅ make sure this model exists

class StudentClassController extends Controller
{
    public function index()
    {
        $classes = Auth::user()->classes;
        return view('student.classes', compact('classes'));
    }

    public function show(ClassModel $class)
    {
        $student = Auth::user();

        // Load activities with only this student's scores
        $activities = $class->activities()->with([
            'scores' => function ($query) use ($student) {
                $query->where('user_id', $student->id);
            }
        ])->get();

        return view('student.classes.show', compact('class', 'activities'));
    }
}
