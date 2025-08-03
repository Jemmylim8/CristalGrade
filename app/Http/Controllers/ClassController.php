<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use Illuminate\Support\Str;

class ClassController extends Controller
{
    //  Show all classes for admin, or faculty's own classes
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $classes = ClassModel::with('faculty')->get();
        } else {
            $classes = ClassModel::where('faculty_id', auth()->id())->get();
        }

        return view('classes.index', compact('classes'));
    }

    // Show class creation form
    public function create(Request $request)
    {
        $selectedYear = $request->query('year'); // grab ?year= from URL
        return view('classes.create', compact('selectedYear'));
    }

    //  Store new class
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'section' => 'required|string|max:50',
            'year_level' => 'required|integer|between:1,4',
        ]);

        ClassModel::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'section' => $request->section,
            'faculty_id' => auth()->id(),
            'join_code' => strtoupper(Str::random(6)), // generate join code
            'year_level' => $request->year_level,
        ]);

        return redirect()->route('classes.index')->with('success', 'Class created successfully!');
    }
    //Join Class
    public function joinClass(Request $request)
    {
        $request->validate([
            'join_code' => 'required|string|size:6',
        ]);

        $class = ClassModel::where('join_code', $request->join_code)->first();

        if (!$class) {
            return back()->withErrors(['join_code' => 'Invalid class code.']);
        }

        // attach student to class
        auth()->user()->classes()->syncWithoutDetaching([$class->id]);

        return back()->with('success', 'You have successfully joined the class!');
    }
    //Load Students for a class
    public function show(ClassModel $class)
    {
        // Load students for that class
        $students = $class->students;

        return view('classes.show', compact('class', 'students'));
    }


}
