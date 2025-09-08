<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class StudentClassController extends Controller
{
    public function index()
    {
        $classes = auth()->user()->classes;
        return view('student.classes', compact('classes'));
    }

use Illuminate\Support\Facades\Auth;

    public function show(ClassModel $class)
{
    $student = Auth::user();

    // Load only the activities of the class
    $activities = $class->activities()->with([
        'scores' => function ($query) use ($student) {
            $query->where('user_id', $student->id);
        }
    ])->get();

    return view('student.classes.show', compact('class', 'activities'));
}


}
