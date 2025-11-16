<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\Activity;
use App\Models\User;
use PDF;

class PdfController extends Controller
{
    public function exportScores($classId)
    {
        $class = ClassModel::findOrFail($classId);
        $students = $class->students;
        $activities = Activity::where('class_id', $classId)->get();

        $pdf = PDF::loadView('pdf.scores', compact('class', 'students', 'activities'));

        return $pdf->download($class->name . '_scores.pdf');
    }

    public function exportAttendance($classId)
    {
        $class = ClassModel::findOrFail($classId);
        $students = $class->students;

        // group by student + date
        $attendance = Attendance::where('class_id', $classId)
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy('student_id');

        $pdf = PDF::loadView('pdf.attendance', compact('class', 'students', 'attendance'));

        return $pdf->download($class->name . '_attendance.pdf');
    }
}
