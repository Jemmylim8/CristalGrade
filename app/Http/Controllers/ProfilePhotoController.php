<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilePhotoController extends Controller
{
    public function update(Request $request)
{
    $request->validate([
        'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = Auth::user();

    // Create upload folder if not existing
    if (!file_exists(public_path('uploads/profile'))) {
        mkdir(public_path('uploads/profile'), 0777, true);
    }

    // Delete old photo if exists
    if ($user->profile_photo && file_exists(public_path('uploads/profile/' . $user->profile_photo))) {
        unlink(public_path('uploads/profile/' . $user->profile_photo));
    }

    // Save new photo
    $filename = time() . '.' . $request->profile_photo->extension();
    $request->profile_photo->move(public_path('uploads/profile'), $filename);

    $user->profile_photo = $filename;
    $user->save();

    return back()->with('success', 'Profile photo updated!');
}

}
