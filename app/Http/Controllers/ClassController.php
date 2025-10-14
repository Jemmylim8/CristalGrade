<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use Illuminate\Support\Str;
use App\Models\Activity;
use App\Models\User;

class ClassController extends Controller
{
    // Show all classes
    public function index()
    {
        $user = auth()->user();

        $classes = $user->role === 'admin'
            ? ClassModel::with('faculty')->get()
            : ClassModel::where('faculty_id', $user->id)->get();

        return view('classes.index', compact('classes'));
    }

    // Show class creation form
    public function create(Request $request)
    {
        $selectedYear = $request->query('year');
        return view('classes.create', compact('selectedYear'));
    }

    // Store new class
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'section' => 'required|string|max:50',
            'schedule' => 'required|string|max:50',
            'year_level' => 'required|integer|between:1,4',
        ]);

        ClassModel::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'section' => $request->section,
            'schedule' => $request->schedule,
            'faculty_id' => auth()->id(),
            'join_code' => strtoupper(Str::random(6)),
            'year_level' => $request->year_level,
        ]);

        return redirect()->route('dashboard.faculty')->with('success', 'Class created successfully!');
    }

    // Edit form
    public function edit(ClassModel $class)
    {
        
        return view('classes.edit', compact('class'));
    }

    // Update existing class
    public function update(Request $request, ClassModel $class)
    {
        

        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'section' => 'required|string|max:50',
            'schedule' => 'required|string|max:50',
            'year_level' => 'required|integer|between:1,4',
        ]);

        $class->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'section' => $request->section,
            'schedule' => $request->schedule,
            'year_level' => $request->year_level,
        ]);

        return redirect()->route('dashboard.faculty')->with('success', 'Class updated successfully!');
    }

    // Delete class
    public function destroy(ClassModel $class)
    {
        

        // Optionally detach all students
        $class->students()->detach();

        // Cascade delete activities/scores
        $class->activities()->delete();

        $class->delete();

        return redirect()->route('dashboard.faculty')->with('success', 'Class deleted successfully!');
    }

    // Join class
    public function joinClass(Request $request)
    {
        $request->validate([
            'join_code' => 'required|string|size:6',
        ]);

        $class = ClassModel::where('join_code', $request->join_code)->first();

        if (!$class) {
            return back()->withErrors(['join_code' => 'Invalid class code.']);
        }

        auth()->user()->classes()->syncWithoutDetaching([$class->id]);

        return back()->with('success', 'You have successfully joined the class!');
    }

    // Show class details
    public function show(ClassModel $class)
    {
        $students = $class->students()->get();
        $activities = $class->activities()->get();

        $studentKeys = $students->pluck('id')->unique()->values()->toArray();
        $activityIds = $activities->pluck('id')->toArray();

        $scoresRaw = \App\Models\Score::whereIn('student_id', $studentKeys)
            ->whereIn('activity_id', $activityIds)
            ->get();

        $scores = [];
        foreach ($scoresRaw as $r) {
            $scores[$r->student_id][$r->activity_id] = $r->score;
        }

        return view('classes.show', compact('class', 'students', 'activities', 'scores'));
    }

    // Year-level view
    public function yearLevel($year_level)
    {
        $facultyId = auth()->id();

        $classes = ClassModel::where('faculty_id', $facultyId)
            ->where('year_level', $year_level)
            ->get();

        return view('faculty.year_level', compact('classes', 'year_level'));
    }

    // Store activity
    public function storeActivity(Request $request, $classId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_score' => 'required|integer|min:1',
        ]);

        Activity::create([
            'class_id' => $classId,
            'title' => $request->title,
            'description' => $request->description,
            'total_score' => $request->total_score, // ✅ fixed key
        ]);

        return redirect()->route('classes.show', $classId)
            ->with('success', 'Activity created successfully!');
    }

    // Remove student from class
    public function removeStudent(ClassModel $class, User $student)
    {
        $class->students()->detach($student->id);
        return redirect()->back()->with('success', $student->name . ' has been removed from the class.');
    }
}
