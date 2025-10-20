<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Announcement;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $classes = auth()->user()->classes;

        // Get all announcements for students (view-only)
        $announcements = Announcement::with('user')->latest()->get();

        return view('dashboards.student', compact('classes', 'announcements'));
    }
}
