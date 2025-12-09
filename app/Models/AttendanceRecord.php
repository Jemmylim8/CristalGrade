<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = ['attendance_id', 'student_id', 'status', 'remarks','excuse_file','excuse_status'];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id');
    }
}
