<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory; //  Only needed for factory support
    protected $table = 'classes';
    protected $fillable = [
        'name',
        'subject',
        'schedule',
        'section',
        'faculty_id',
        'join_code',
        'year_level'
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

    
    public function activities()
    {
        return $this->hasMany(Activity::class, 'class_id');
    }

}
