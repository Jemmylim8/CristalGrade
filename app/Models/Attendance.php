<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['class_id', 'date', 'created_by'];

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    // Replace ClassModel with your real class model name if needed
    public function class()
    {
        return $this->belongsTo(\App\Models\ClassModel::class, 'class_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
