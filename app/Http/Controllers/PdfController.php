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
        $attendances = $class->attendances()->orderBy('date')->get();

        $records = [];
        foreach ($students as $student) {
        $records[$student->id] = [];
        foreach ($attendances as $att) {
            $record = $att->attendanceRecords()->where('student_id', $student->id)->first();
            $records[$student->id][$att->id] = $record 
                ? ($record->status . ($record->remarks ? " ({$record->remarks})" : '')) 
                : 'Absent';
        }
    }


        $pdf = PDF::loadView('pdf.attendance', compact('class','students','attendances','records'));
        return $pdf->download($class->name . '_attendance.pdf');
    }
}