<?php

use App\Http\Controllers\EmployerJobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\StudentResumeController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/login/select', function () {
        return view('auth.login-selection');
    })->name('login.select');

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


Route::middleware(['auth', 'role:employer'])->prefix('employer')->group(function () {
    Route::get('/jobs', [EmployerJobController::class, 'create'])->name('employer.jobs');
    Route::post('/jobs', [EmployerJobController::class, 'store'])->name('employer.jobs.store');
    Route::get('/manage-jobs', [EmployerJobController::class, 'index'])->name('employer.manage-jobs');
    Route::put('/jobs/{job}', [EmployerJobController::class, 'update'])->name('employer.jobs.update');
    Route::get('/dashboard', function () { return view('employer.dashboard'); })->name('employer.dashboard');
    Route::get('/applicants', function () { return view('employer.applicants'); })->name('employer.applicants');
    Route::get('/applicant-details', function () { return view('employer.applicant-details'); })->name('employer.applicant-details');
    Route::get('/interview-schedule', function () { return view('employer.interview-schedule'); })->name('employer.interview-schedule');
    Route::get('/schedule-interview', function () { return view('employer.schedule-interview'); })->name('employer.schedule-interview');
    Route::get('/company-profile', function () { return view('employer.company-profile'); })->name('employer.company-profile');
    Route::get('/notifications', function () { return view('employer.notifications'); })->name('employer.notifications');
});


Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', function () { return view('student.dashboard'); })->name('student.dashboard');
    Route::get('/profile', [StudentProfileController::class, 'edit'])->name('student.profile');
    Route::post('/profile', [StudentProfileController::class, 'update'])->name('student.profile.update');
    Route::get('/resume', [StudentResumeController::class, 'edit'])->name('student.resume');
    Route::post('/resume', [StudentResumeController::class, 'store'])->name('student.resume.upload');
    Route::get('/resume/download', [StudentResumeController::class, 'download'])->name('student.resume.download');
    Route::get('/resume-review', function () { return view('student.resume-review'); })->name('student.resume-review');
    Route::get('/skills', function () { return view('student.skills'); })->name('student.skills');
    Route::get('/jobs', function () { return view('student.jobs'); })->name('student.jobs');
    Route::get('/applications', function () { return view('student.applications'); })->name('student.applications');
    Route::get('/interviews', function () { return view('student.interviews'); })->name('student.interviews');
    Route::get('/notifications', function () { return view('student.notifications'); })->name('student.notifications');
});

require __DIR__.'/auth.php';
