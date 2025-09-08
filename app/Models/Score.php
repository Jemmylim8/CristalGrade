<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['student_id', 'activity_id', 'score'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
    public function scores()
    {
        return $this->hasMany(Score::class, 'activity_id');
    }

}
