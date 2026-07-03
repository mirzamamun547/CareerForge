<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.select-role');
    })->name('register');

    Route::get('/register/student', function () {
        return view('auth.register-student');
    })->name('register.student');

    Route::get('/register/employer', function () {
        return view('auth.register-employer');
    })->name('register.employer');

    Route::get('/login/student', function () {
        return view('auth.login-student');
    })->name('login.student');

    Route::get('/login/employer', function () {
        return view('auth.login-employer');
    })->name('login.employer');

    Route::get('/login/admin', function () {
        return view('auth.login-admin');
    })->name('login.admin');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/employer/jobs', function () { return view('employer.jobs'); });
Route::get('/employer/manage-jobs', function () { return view('employer.manage-jobs'); });
Route::get('/employer/dashboard', function () { return view('employer.dashboard'); });
Route::get('/employer/applicants', function () { return view('employer.applicants'); });
Route::get('/employer/applicant-details', function () { return view('employer.applicant-details'); });
Route::get('/employer/interview-schedule', function () { return view('employer.interview-schedule'); });
Route::get('/employer/schedule-interview', function () { return view('employer.schedule-interview'); });
Route::get('/employer/company-profile', function () { return view('employer.company-profile'); });
Route::get('/employer/notifications', function () { return view('employer.notifications'); });


Route::get('/student/dashboard', function () { return view('student.dashboard'); });
Route::get('/student/profile', function () { return view('student.profile'); });
Route::get('/student/resume', function () { return view('student.resume'); });
Route::get('/student/resume-review', function () { return view('student.resume-review'); });
Route::get('/student/skills', function () { return view('student.skills'); });
Route::get('/student/jobs', function () { return view('student.jobs'); });
Route::get('/student/applications', function () { return view('student.applications'); });
Route::get('/student/interviews', function () { return view('student.interviews'); });
Route::get('/student/notifications', function () { return view('student.notifications'); });

require __DIR__.'/auth.php';
