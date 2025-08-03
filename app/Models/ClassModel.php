<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory; // ✅ Only needed for factory support
    protected $table = 'classes';
    protected $fillable = [
        'name',
        'subject',
        'section',
        'faculty_id',
        'join_code',
    ];
    //To show The classes belonging to the Faculty using
    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }
    // to use $user->classes; = all classes a student joined
    public function students()
    {
        return $this->belongsToMany(User::class, 'class_student', 'class_id', 'student_id');
    }
    // to use $class->students; = all students in a class
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_student', 'student_id', 'class_id');
    }

}
