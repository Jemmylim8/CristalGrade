<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\FacultyDashboardController;
use App\Http\Controllers\ActivityController;

Route::get('/two-factor', [TwoFactorController::class, 'index'])->name('two-factor.index');
Route::post('/two-factor', [TwoFactorController::class, 'store'])->name('two-factor.store');
Route::get('/', function () {
    return view('welcome');
});
//Admin Account Creation for Faculty/Student
Route::middleware(['auth', 'verified', 'twofactor'])->group(function () {
    Route::get('/admin/users/create', [\App\Http\Controllers\Admin\UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/create', [\App\Http\Controllers\Admin\UserManagementController::class, 'store'])->name('admin.users.store');
});
// From Admin dashboard to Creation
Route::get('/admin/dashboard', function () {
    return view('dashboards.admin');
})->name('admin.dashboard');

Route::get('/admin/users/create/', [UserManagementController::class, 'create'])
    ->name('admin.users.create');

Route::post('/admin/users/create/', [UserManagementController::class, 'store'])
    ->name('admin.users.store');


//  SMART DASHBOARD REDIRECT BASED ON USER ROLE
Route::middleware(['auth', 'verified', 'twofactor'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $role = strtolower($user->role);
        return match ($role) {
            'admin' => redirect('/dashboard/admin'),
            'faculty' => redirect('/dashboard/faculty'),
            default => redirect('/dashboard/student'),
        };
    })->name('dashboard');

    //  All dashboards now also require verification
    Route::get('/dashboard/admin', fn() => view('dashboards.admin'));
    // Route::get('/dashboard/faculty', fn() => view('dashboards.faculty'));
    Route::get('/dashboard/faculty', [FacultyDashboardController::class, 'index']);
    Route::get('/dashboard/student', fn() => view('dashboards.student'));
});


// Class Creation Routes
Route::middleware(['auth', 'verified'])->group(function () {

    //  Classes Index & Create
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');
    Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');

});
//Class Joining Route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/classes/join', [\App\Http\Controllers\ClassController::class, 'joinClass'])->name('classes.join');
});
//Class With students
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/classes/{class}', [\App\Http\Controllers\ClassController::class, 'show'])->name('classes.show');
});
//Class remove student enrolled
Route::delete('/classes/{class}/students/{student}', [ClassController::class, 'removeStudent'])
    ->name('classes.students.remove');

//Student View Classes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/student/classes', [\App\Http\Controllers\StudentClassController::class, 'index'])->name('student.classes');
});
// Faculty year level detail
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/faculty/year/{year_level}', [ClassController::class, 'yearLevel'])
        ->name('faculty.yearLevel');
});
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard/student', [\App\Http\Controllers\StudentDashboardController::class, 'index'])
        ->name('dashboard.student');
});
//Adding Activity
// Activities inside a class
// Activities inside a class
Route::middleware(['auth'])->group(function () {
    Route::get('/classes/{class}/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/classes/{class}/activities/create', [ActivityController::class, 'create'])->name('activities.create');
    Route::post('/classes/{class}/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/classes/{class}/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/classes/{class}/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/classes/{class}/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

    // Save all scores from the class page
    Route::post('/classes/{class}/activities/scores', [ActivityController::class, 'saveScores'])
        ->name('activities.scores.save');
});

//Score SAving




// Route::get('/dashboard', [DashboardController::class, 'index'])
//     ->middleware(['auth', 'verified', 'twofactor'])
//     ->name('dashboard');

// Route::middleware(['auth', 'verified', 'twofactor'])->group(function () {
//     Route::get('/dashboard/admin', function () {
//         return view('dashboards.admin');
//     })->name('dashboard.admin');

//     Route::get('/dashboard/faculty', function () {
//         return view('dashboards.faculty');
//     })->name('dashboard.faculty');

//     Route::get('/dashboard/student', function () {
//         return view('dashboards.student');
//     })->name('dashboard.student');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
