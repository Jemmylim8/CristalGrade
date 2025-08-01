<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\Admin\UserManagementController;

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

    // ✅ All dashboards now also require verification
    Route::get('/dashboard/admin', fn() => view('dashboards.admin'));
    Route::get('/dashboard/faculty', fn() => view('dashboards.faculty'));
    Route::get('/dashboard/student', fn() => view('dashboards.student'));
});


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
