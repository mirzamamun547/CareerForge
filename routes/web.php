<?php

use App\Http\Controllers\EmployerJobController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\StudentJobController;
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
    
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});


Route::middleware(['auth', 'role:employer'])->prefix('employer')->group(function () {
    Route::get('/jobs', [EmployerJobController::class, 'create'])->name('employer.jobs');
    Route::post('/jobs', [EmployerJobController::class, 'store'])->name('employer.jobs.store');
    Route::get('/manage-jobs', [EmployerJobController::class, 'index'])->name('employer.manage-jobs');
    Route::put('/jobs/{job}', [EmployerJobController::class, 'update'])->name('employer.jobs.update');
    Route::get('/dashboard', function () { return view('employer.dashboard'); })->name('employer.dashboard');
    Route::get('/applicants', [StudentJobController::class, 'employerApplicants'])->name('employer.applicants');
    Route::get('/applicant-details/{application}', [StudentJobController::class, 'employerApplicantDetails'])->name('employer.applicant-details');
    Route::post('/applicant-details/{application}/status', [StudentJobController::class, 'employerUpdateStatus'])->name('employer.applicants.status.update');
    Route::post('/applicant-details/{application}/resume-review', [StudentJobController::class, 'employerReviewResume'])->name('employer.applicant-details.resume-review');
    Route::get('/interview-schedule', function () { return view('employer.interview-schedule'); })->name('employer.interview-schedule');
    Route::get('/schedule-interview', function () { return view('employer.schedule-interview'); })->name('employer.schedule-interview');
    Route::get('/company-profile', function () { return view('employer.company-profile'); })->name('employer.company-profile');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('employer.notifications');
});


Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', function () { return view('student.dashboard'); })->name('student.dashboard');
    Route::get('/profile', [StudentProfileController::class, 'edit'])->name('student.profile');
    Route::post('/profile', [StudentProfileController::class, 'update'])->name('student.profile.update');
    Route::get('/resume', [StudentResumeController::class, 'edit'])->name('student.resume');
    Route::post('/resume', [StudentResumeController::class, 'store'])->name('student.resume.upload');
    Route::get('/resume/download', [StudentResumeController::class, 'download'])->name('student.resume.download');
    Route::get('/resume-review', [StudentResumeController::class, 'review'])->name('student.resume-review');
    Route::get('/skills', [SkillController::class, 'index'])->name('student.skills');
    Route::post('/skills', [SkillController::class, 'store'])->name('student.skills.store');
    Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('student.skills.update');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('student.skills.destroy');
    Route::get('/jobs', [StudentJobController::class, 'index'])->name('student.jobs');
    Route::get('/jobs/{job}', [StudentJobController::class, 'show'])->name('student.jobs.show');
    Route::get('/jobs/{job}/apply', [StudentJobController::class, 'showApplyForm'])->name('student.jobs.apply.form');
    Route::post('/jobs/{job}/apply', [StudentJobController::class, 'apply'])->name('student.jobs.apply');
    Route::get('/jobs/{job}/apply/success', [StudentJobController::class, 'applySuccess'])->name('student.jobs.apply.success');
    Route::post('/jobs/{job}/bookmark', [StudentJobController::class, 'bookmark'])->name('student.jobs.bookmark');
    Route::get('/applications', [StudentJobController::class, 'applications'])->name('student.applications');
    Route::post('/applications/{application}/withdraw', [StudentJobController::class, 'withdraw'])->name('student.applications.withdraw');
    Route::get('/interviews', function () { return view('student.interviews'); })->name('student.interviews');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('student.notifications');
});

require __DIR__.'/auth.php';