<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
    'class_id',
    'name',
    'type',          // if you have a type column (Quiz, Exam, etc)
    'total_score',   // instead of max_score
    'due_date',
    ];


    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'activity_student', 'activity_id', 'student_id')
                    ->withPivot('score')
                    ->withTimestamps();
    }
    // Scores for this activity
    public function scores()
    {
        return $this->hasMany(Score::class, 'activity_id');
    }

}
