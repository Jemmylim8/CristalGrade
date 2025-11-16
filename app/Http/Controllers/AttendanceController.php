<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceRecord;
use App\Models\User;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // show attendance sessions and date picker for a class
    public function index($classId)
    {
        // Replace ClassModel with your actual class model
        $class = \App\Models\ClassModel::findOrFail($classId);
        $students = $class->students; // expects relation
        $sessions = Attendance::where('class_id', $classId)->orderBy('date', 'desc')->get();

        return view('attendance.index', compact('class', 'students', 'sessions'));
    }

    // store attendance for a date (creates session + records)
    public function store(Request $request, $classId)
    {
        $request->validate([
            'date' => 'required|date',
            'records' => 'required|array'
        ]);

        $date = Carbon::parse($request->date)->toDateString();

        // Prevent duplicate session for same class/date
        $attendance = Attendance::firstOrCreate(
            ['class_id' => $classId, 'date' => $date],
            ['created_by' => auth()->id()]
        );

        foreach ($request->records as $studentId => $payload) {
            AttendanceRecord::updateOrCreate(
                ['attendance_id' => $attendance->id, 'student_id' => $studentId],
                ['status' => $payload['status'], 'remarks' => $payload['remarks'] ?? null]
            );
        }

        return redirect()->route('attendance.index', $classId)->with('success','Attendance saved.');
    }

    // show a single attendance session (faculty)
    public function show($classId, Attendance $attendance)
    {
        $class = \App\Models\ClassModel::findOrFail($classId);
        $records = $attendance->records()->with('student')->get();

        return view('attendance.show', compact('class','attendance','records'));
    }

    // update a session (change statuses)
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'records' => 'required|array'
        ]);

        foreach ($request->records as $studentId => $payload) {
            AttendanceRecord::updateOrCreate(
                ['attendance_id' => $attendance->id, 'student_id' => $studentId],
                ['status' => $payload['status'], 'remarks' => $payload['remarks'] ?? null]
            );
        }

        return back()->with('success','Attendance updated.');
    }

    // student view (only their records for this class)
    public function studentView($classId)
    {
        $studentId = auth()->id();
        $records = AttendanceRecord::whereHas('attendance', function($q) use ($classId) {
            $q->where('class_id', $classId);
        })->where('student_id', $studentId)->with('attendance')->orderByDesc('created_at')->get();

        // optional: load class details
        $class = \App\Models\ClassModel::findOrFail($classId);

        return view('attendance.student', compact('class','records'));
    }

    // PDF export (requires dompdf)
    public function exportPdf($classId, Request $request)
    {
        $date = $request->query('date'); // optional filter
        $class = \App\Models\ClassModel::findOrFail($classId);

        $query = Attendance::where('class_id', $classId)->with(['records.student']);
        if ($date) $query->where('date', $date);

        $sessions = $query->orderBy('date','desc')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.attendance', compact('class','sessions','date'));
        return $pdf->download("attendance-{$class->id}-" . ($date ?: 'all') . ".pdf");
    }
}
