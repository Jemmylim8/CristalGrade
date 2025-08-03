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

    public function faculty()
    {
        return $this->belongsTo(User::class, 'faculty_id');
    }
}
