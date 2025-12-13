<?php

namespace App\Http\Controllers;

use App\Models\ScoreHistory;
use App\Models\ClassModel; // adjust name if different
use Illuminate\Http\Request;

class ScoreHistoryController extends Controller
{
    public function index($classId)
    {
        $history = ScoreHistory::with(['student', 'activity', 'faculty'])
            ->whereHas('activity', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('history.index', [
            'history' => $history,
            'classId' => $classId
        ]);
    }
    public function showHistory()
{
    $studentId = auth()->id();

    // Get the student's score history, latest first, paginated
    $history = ScoreHistory::with(['activity','faculty'])
        ->where('student_id', $studentId)
        ->orderBy('created_at', 'desc')  // or changed_at if you have it
        ->paginate(15);  // 15 per page
     $classId = null;

        if ($history->isNotEmpty() && $history->first()->activity) {
            $classId = $history->first()->activity->class_id;
        }
    return view('history.student', [
        'history' => $history,
        'classId' => $classId
    ]);
}
}
