<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function checkFacultyOwnership($class)
    {
        if (auth()->user()->role === 'faculty' && $class->faculty_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
    protected function checkStudentMembership($class)
    {
        $user = auth()->user();

        // Only students need this check
        if ($user->role !== 'student') {
            return;
        }

        // Student must belong to this class
        $isMember = $class->students->contains('id', $user->id);

        if (! $isMember) {
            abort(403, 'Unauthorized access.');
        }
    }

}
