<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    // Show all announcements
 public function index()
{
    // Paginated for full index page
    $announcements = Announcement::with('user')->latest()->paginate(10);

    // Latest 5 announcements for sidebar
    $sidebarAnnouncements = Announcement::with('user')->latest()->take(5)->get();

    return view('announcements.index', compact('announcements', 'sidebarAnnouncements'));
}


    // Show form to create new announcement
    public function create()
    {
        if (!in_array(auth()->user()->role, ['faculty', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('announcements.create');
    }

    // Store new announcement
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['faculty', 'admin'])) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachment' => 'nullable|file|max:2048',
        ]);

        $path = $request->hasFile('attachment')
            ? $request->file('attachment')->store('attachments', 'public')
            : null;

        Announcement::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'attachment_path' => $path,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Announcement posted successfully!');
    }

    // Show edit form
    // Show edit form
public function edit(Announcement $announcement)
{
    $user = auth()->user();

    if ($user->role === 'faculty' && $announcement->user_id !== $user->id) {
        abort(403, 'You can only edit your own announcements.');
    }

    if (!in_array($user->role, ['faculty', 'admin'])) {
        abort(403, 'Unauthorized action.');
    }

    return view('announcements.edit', compact('announcement'));
}

// Update announcement
public function update(Request $request, Announcement $announcement)
{
    $user = auth()->user();

    if ($user->role === 'faculty' && $announcement->user_id !== $user->id) {
        abort(403, 'You can only update your own announcements.');
    }

    if (!in_array($user->role, ['faculty', 'admin'])) {
        abort(403, 'Unauthorized action.');
    }

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
    ]);

    if ($request->hasFile('attachment')) {
        if ($announcement->attachment_path) {
            \Storage::disk('public')->delete($announcement->attachment_path);
        }
        $data['attachment_path'] = $request->file('attachment')->store('attachments', 'public');
    }

    $announcement->update($data);

    return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully!');
}

// Delete announcement
public function destroy(Announcement $announcement)
{
    $user = auth()->user();

    if ($user->role === 'faculty' && $announcement->user_id !== $user->id) {
        abort(403, 'You can only delete your own announcements.');
    }

    if (!in_array($user->role, ['faculty', 'admin'])) {
        abort(403, 'Unauthorized');
    }

    if ($announcement->attachment_path) {
        \Storage::disk('public')->delete($announcement->attachment_path);
    }

    $announcement->delete();

    return back()->with('success', 'Announcement deleted successfully.');
}

}
