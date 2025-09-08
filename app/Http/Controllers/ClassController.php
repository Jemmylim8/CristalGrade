<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use Illuminate\Support\Str;
use App\Models\Activity;
use App\Models\User;


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
            'schedule' => 'required|string|max:50',
            'year_level' => 'required|integer|between:1,4',
        ]);

        ClassModel::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'section' => $request->section,
            'schedule' => $request->schedule,
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
    //Load Students and Activvites for a class
public function show(\App\Models\ClassModel $class)
{
    // load students & activities
    $students = $class->students()->get();
    $activities = $class->activities()->get();

    // collect the list of student keys we will use in the blade
    $studentKeys = $students->map(function($s){
        return $s->student_id ?? $s->student_id ?? $s->id;
    })->unique()->values()->toArray();

    $activityIds = $activities->pluck('id')->toArray();

    // load existing scores only for these students & activities
    $scoresRaw = \App\Models\Score::whereIn('student_id', $studentKeys)   // if your scores table uses user_id
                  ->whereIn('activity_id', $activityIds)
                  ->get();

    // build nested array: $scores[user_or_student_id][activity_id] = score
    $scores = [];
    foreach ($scoresRaw as $r) {
        $scores[$r->student_id][$r->activity_id] = $r->score;
    }

    // if your scores table uses student_id column, adjust query & mapping above:
    // whereIn('student_id', $studentKeys) and $scores[$r->student_id][$r->activity_id] = $r->score;

    return view('classes.show', compact('class','students','activities','scores'));
}




    public function yearLevel($year_level)
    {
        $facultyId = auth()->id();

        // Fetch all classes for this faculty in the given year level
        $classes = ClassModel::where('faculty_id', $facultyId)
            ->where('year_level', $year_level)
            ->get();

        return view('faculty.year_level', compact('classes', 'year_level'));
    }

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
            'total_score' => $request->max_score,
        ]);

        return redirect()->route('classes.show', $classId)
            ->with('success', 'Activity created successfully!');
    }
    public function removeStudent(ClassModel $class, User $student)
    {
        // Detach student from this class
        $class->students()->detach($student->id);

        return redirect()->back()->with('success', $student->name . ' has been removed from the class.');
    }


}
