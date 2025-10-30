<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Models\User;

class ActivityController extends Controller
{
    // List activities for a class
    public function index(ClassModel $class)
    {
        $activities = $class->activities()->with('students')->get();
        return view('activities.index', compact('class', 'activities'));
    }

    // Show create form
    public function create(ClassModel $class)
    {
        return view('activities.create', compact('class'));
    }

    // Store activity
//     public function store(Request $request, ClassModel $class)
// {
//     dd($request->all()); // dump everything sent
// }

    public function store(Request $request, ClassModel $class)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Quiz,Exam,Assignment',
            'total_score' => 'required|integer|min:1',
            'due_date' => 'nullable|date',
        ]);
        $data['code'] = random_int(1000, 9999);

    // Default lock status (locked = cannot use code on student side yet)
        $data['is_locked'] = true;
        $class->activities()->create($data);

        return redirect()->route('classes.show', $class->id)
                         ->with('success', 'Activity added successfully.');
    }

    // Show edit form
    public function edit(ClassModel $class, Activity $activity)
    {
        return view('classes.edit', compact('class', 'activity'));
    }

    // Update activity
    public function update(Request $request, ClassModel $class, Activity $activity)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Quiz,Exam,Assignment',
            'total_score' => 'required|integer|min:1',
            'due_date' => 'nullable|date',
        ]);

        $activity->update($data);

        return redirect()->route('classes.show', $class->id)
                         ->with('success', 'Activity updated successfully.');
    }

    // Delete activity
    public function destroy(ClassModel $class, Activity $activity)
    {
        $activity->delete();
        return redirect()->route('classes.show', $class->id)
                         ->with('success', 'Activity deleted successfully.');
    }

    // Show score entry form
    public function scores(ClassModel $class, Activity $activity)
    {
        $students = $class->students()->get();
        return view('activities.scores', compact('class', 'activity', 'students'));
    }

    // Save scores
public function showScores(ClassModel $class)
{
    $activities = $class->activities()->with('students')->get();
    $students = $class->students()->get();

    // Ensure all pivot records exist (optional but prevents missing pivot)
    foreach ($activities as $activity) {
        foreach ($students as $student) {
            $activity->students()->syncWithoutDetaching([
                $student->id => ['score' => $activity->students->where('id', $student->id)->first()?->pivot->score ?? null]
            ]);
        }
    }

    return view('classes.show', compact('class', 'activities', 'students'));
}

public function toggleLock($id)
{
    if (auth()->user()->role !== 'faculty') {
        abort(403, 'Unauthorized action.');
    }
    $activity = \App\Models\Activity::findOrFail($id);

    $activity->is_locked = !$activity->is_locked;
    $activity->save();

    return response()->json([
        'success' => true,
        'is_locked' => $activity->is_locked,
        'message' => $activity->is_locked ? 'Activity locked' : 'Activity unlocked'
    ]);
}



    
}
