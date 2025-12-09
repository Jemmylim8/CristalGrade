<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id', 'student_id', 'class_id','activity_id',
        'component', 'old_score', 'new_score', 'meta'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function faculty()
    {
        return $this->belongsTo(\App\Models\User::class, 'faculty_id');
    }

    public function student()
    {
        return $this->belongsTo(\App\Models\User::class, 'student_id');
    }
     public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
    // If your class model is named differently, update the relation:
    public function class()
    {
        return $this->belongsTo(\App\Models\ClassModel::class, 'class_id');
    }
}
