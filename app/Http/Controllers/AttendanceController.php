<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceRecord;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Show attendance sessions and date picker for a class
    public function index($classId)
    {
        $class = \App\Models\ClassModel::findOrFail($classId);
        $students = $class->students; // expects relation
        $sessions = Attendance::where('class_id', $classId)
            ->orderBy('date', 'desc')
            ->get();

        return view('attendance.index', compact('class', 'students', 'sessions'));
    }

    // Store or overwrite attendance
    public function store(Request $request, $classId)
    {
        $request->validate([
            'date' => 'required|date',
            'records' => 'required|array'
        ]);

        $date = Carbon::parse($request->date)->toDateString();

        // Check if attendance already exists
        $existing = Attendance::where('class_id', $classId)
            ->whereDate('date', $date)
            ->first();

        // If exists and user has NOT confirmed overwrite
        if ($existing && !$request->boolean('confirm')) {
            return back()->with([
                'warning'  => 'Attendance for this date already exists. Do you want to overwrite it?',
                'old_date' => $date
            ])->withInput(); // preserves records
        }

        // If exists and confirm=1 → overwrite
        if ($existing) {
            $attendance = $existing;
            $attendance->records()->delete(); // delete old records
        } else {
            // Otherwise create new attendance
            $attendance = Attendance::create([
                'class_id'   => $classId,
                'date'       => $date,
                'created_by' => auth()->id(),
            ]);
        }

        // Store or update records
        foreach ($request->input('records', []) as $studentId => $payload) {
            AttendanceRecord::create([
                'attendance_id' => $attendance->id,
                'student_id'    => $studentId,
                'status'        => $payload['status'],
                'remarks'       => $payload['remarks'] ?? null
            ]);
        }

        return redirect()->route('attendance.index', $classId)
            ->with('success', 'Attendance saved successfully.');
    }

    // Destroy attendance session
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $classId = $attendance->class_id;

        $attendance->records()->delete();
        $attendance->delete();

        return redirect()->route('attendance.index', $classId)
            ->with('success', 'Attendance deleted successfully.');
    }

    // AJAX check if attendance exists
    public function check($classId, $date)
    {
        $exists = Attendance::where('class_id', $classId)
            ->whereDate('date', $date)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    // Show a single attendance session
    public function show($classId, Attendance $attendance)
    {
        $class = \App\Models\ClassModel::findOrFail($classId);
        $records = $attendance->records()->with('student')->get();

        return view('attendance.show', compact('class','attendance','records'));
    }

    // Update a session (statuses/remarks)
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

    // Student view of attendance
    public function studentView($classId)
    {
        $studentId = auth()->id();
        $records = AttendanceRecord::whereHas('attendance', function($q) use ($classId) {
                $q->where('class_id', $classId);
            })
            ->where('student_id', $studentId)
            ->with('attendance')
            ->orderByDesc('created_at')
            ->get();

        $class = \App\Models\ClassModel::findOrFail($classId);

        return view('attendance.student', compact('class','records'));
    }

    // PDF export
    public function exportPdf($classId, Request $request)
    {
        $date = $request->query('date');
        $class = \App\Models\ClassModel::findOrFail($classId);

        $query = Attendance::where('class_id', $classId)
            ->with(['records.student']);
        if ($date) $query->where('date', $date);

        $sessions = $query->orderBy('date','desc')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.attendance', compact('class','sessions','date'));
        return $pdf->download("attendance-{$class->id}-" . ($date ?: 'all') . ".pdf");
    }
}
