<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    // Show scores for a single activity
    public function showScores(Activity $activity)
    {
        $activity->load('scores.student'); // eager load scores with student info

        return view('scores.show', compact('activity'));
    }

    // Show form to edit scores
    public function edit(Activity $activity)
    {
        $activity->load('scores.student', 'class.students'); // get all students in class

        // Map scores by student_id for easy access in the form
        $scores = $activity->scores->keyBy('student_id');

        return view('scores.edit', compact('activity', 'scores'));
    }

    // Save/update scores for a single activity
public function update(Request $request, $classId)
{
    $request->validate([
        'scores' => 'required|array',
        'scores.*.*' => 'nullable|numeric|min:0',
    ]);

    $scoresData = $request->input('scores', []);

    foreach ($scoresData as $studentId => $activities) {
        foreach ($activities as $activityId => $scoreValue) {
            // Skip empty inputs
            if ($scoreValue === '' || $scoreValue === null) continue;

            // Get existing score (if any)
            $existingScore = \App\Models\Score::where('student_id', $studentId)
                ->where('activity_id', $activityId)
                ->first();

            $oldScore = $existingScore?->score;     // null if new
            $newScore = (float) $scoreValue;

            // Log history ONLY if the score changes
            if ($existingScore && (float)$oldScore !== $newScore) {
                \App\Models\ScoreHistory::create([
                    'faculty_id' => auth()->id(),
                    'student_id' => $studentId,
                    'class_id'   => $classId,
                    'component'  => $existingScore->activity->name ?? 'Activity ' . $activityId,
                    'activity_id'=> $activityId,
                    'old_score'  => $oldScore,
                    'new_score'  => $newScore,
                    'meta'       => [
                        'ip' => $request->ip(),
                        'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                    ],
                ]);
            }

            // Save or update score
            \App\Models\Score::updateOrCreate(
                [
                    'student_id' => (int) $studentId,
                    'activity_id' => (int) $activityId,
                ],
                ['score' => $newScore]
            );
        }
    }

    return redirect()->back()->with('success', 'Scores saved successfully!');
}




}
