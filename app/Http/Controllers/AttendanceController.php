<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceRecord;
use App\Models\ClassModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    // Show attendance sessions for a class
    public function index($classId)
    {
        $class = ClassModel::findOrFail($classId);
        $this->checkFacultyOwnership($class);
        $this->checkStudentMembership($class);

        $students = $class->students;
        $sessions = Attendance::where('class_id', $classId)
            ->orderByDesc('date')
            ->get();

        return view('attendance.index', compact('class','students','sessions'));
    }

    // Store attendance
    public function store(Request $request, $classId)
    {
        $class = ClassModel::findOrFail($classId);
        $this->checkFacultyOwnership($class);

        $request->validate([
            'date' => 'required|date',
            'records' => 'required|array'
        ]);

        $date = Carbon::parse($request->date)->toDateString();

        $existing = Attendance::where('class_id', $classId)
            ->whereDate('date', $date)
            ->first();

        if ($existing && !$request->boolean('confirm')) {
            return back()->with([
                'warning'  => 'Attendance for this date already exists. Do you want to overwrite it?',
                'old_date' => $date
            ])->withInput();
        }

        if ($existing) {
            $attendance = $existing;
            $attendance->records()->delete();
        } else {
            $attendance = Attendance::create([
                'class_id' => $classId,
                'date' => $date,
                'created_by' => auth()->id(),
            ]);
        }

        foreach ($request->input('records', []) as $studentId => $payload) {
            AttendanceRecord::create([
                'attendance_id' => $attendance->id,
                'student_id' => $studentId,
                'status' => $payload['status'],
                'remarks' => $payload['remarks'] ?? null
            ]);
        }

        return redirect()->route('attendance.index', $classId)
            ->with('success','Attendance saved successfully.');
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
    $class = ClassModel::findOrFail($classId);
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
        $class = ClassModel::findOrFail($classId);
        $this->checkFacultyOwnership($class);

        $date = $request->query('date');
        $query = Attendance::where('class_id', $classId)->with(['records.student']);
        if ($date) $query->whereDate('date', $date);

        $sessions = $query->orderByDesc('date')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.attendance', compact('class','sessions','date'));
        return $pdf->download("attendance-{$class->id}-" . ($date ?: 'all') . ".pdf");
    }


public function uploadExcuse(Request $request, $id)
{
    $request->validate([
        'excuse_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $record = AttendanceRecord::findOrFail($id);

    // Delete old file if exists
    if ($record->excuse_file && Storage::disk('public')->exists($record->excuse_file)) {
        Storage::disk('public')->delete($record->excuse_file);
    }

    // Store new file
    $path = $request->file('excuse_file')->store('excuses', 'public');

    $record->update([
        'excuse_file' => $path,
        'excuse_status' => 'Pending', // optional
    ]);

    return back()->with('success', 'Excuse uploaded/updated successfully!');
}

public function deleteExcuse($id)
{
    $record = AttendanceRecord::findOrFail($id);

    if ($record->excuse_file && Storage::disk('public')->exists($record->excuse_file)) {
        Storage::disk('public')->delete($record->excuse_file);
    }

    $record->update([
        'excuse_file' => null,
         // optional: revert status
    ]);

    return back()->with('success', 'Excuse deleted successfully!');
}
public function approveExcuse($id)
{
    $record = AttendanceRecord::findOrFail($id);

    $record->update([
        'excuse_status' => 'Approved', // update the correct column
    ]);

    return back()->with('success', 'Excuse approved successfully!');
}

public function rejectExcuse($id)
{
    $record = AttendanceRecord::findOrFail($id);

    $record->update([
        'excuse_status' => 'Rejected', // update the correct column
    ]);

    return back()->with('success', 'Excuse rejected successfully!');
}


}
