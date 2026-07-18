<?php

use App\Http\Controllers\EmployerJobController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\StudentJobController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\StudentResumeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\InterviewController;
use Illuminate\Support\Facades\Route;

Route::get('/gemini-test', [GeminiController::class, 'test']);
Route::post('/gemini/generate', [GeminiController::class, 'generateFromRequest']);

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
    Route::get('/dashboard', function () {
        $jobs = auth()->user()->jobListings()->latest()->take(5)->get();
        $totalActiveJobs = auth()->user()->jobListings()->where('status', 'Active')->count();
        $totalApplicants = \App\Models\JobApplication::whereIn('job_listing_id', auth()->user()->jobListings()->pluck('id'))->count();
        return view('employer.dashboard', compact('jobs', 'totalActiveJobs', 'totalApplicants'));
    })->name('employer.dashboard');
    Route::get('/applicants', [StudentJobController::class, 'employerApplicants'])->name('employer.applicants');
    Route::get('/applicant-details/{application}', [StudentJobController::class, 'employerApplicantDetails'])->name('employer.applicant-details');
    Route::post('/applicant-details/{application}/status', [StudentJobController::class, 'employerUpdateStatus'])->name('employer.applicants.status.update');
    Route::post('/applicant-details/{application}/resume-review', [StudentJobController::class, 'employerReviewResume'])->name('employer.applicant-details.resume-review');
    Route::get('/interview-schedule', [InterviewController::class, 'employerIndex'])->name('employer.interview-schedule');
    Route::get('/schedule-interview', [InterviewController::class, 'create'])->name('employer.schedule-interview');
    Route::post('/schedule-interview', [InterviewController::class, 'store'])->name('employer.schedule-interview.store');
    Route::post('/interviews/{interview}/cancel', [InterviewController::class, 'cancel'])->name('employer.interviews.cancel');
    Route::get('/company-profile', function () { return view('employer.company-profile'); })->name('employer.company-profile');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('employer.notifications');
});


Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', function () {
        $recommendedJobs = \App\Models\JobListing::where('status', 'Active')->latest()->take(5)->get();
        $totalApplications = auth()->user()->jobApplications()->count();
        $totalInterviews = auth()->user()->interviewsAsStudent()->upcoming()->count();
        return view('student.dashboard', compact('recommendedJobs', 'totalApplications', 'totalInterviews'));
    })->name('student.dashboard');
    Route::get('/profile', [StudentProfileController::class, 'edit'])->name('student.profile');
    Route::post('/profile', [StudentProfileController::class, 'update'])->name('student.profile.update');
    Route::get('/resume', [StudentResumeController::class, 'edit'])->name('student.resume');
    Route::post('/resume', [StudentResumeController::class, 'store'])->name('student.resume.upload');
    Route::get('/resume/download', [StudentResumeController::class, 'download'])->name('student.resume.download');
    Route::get('/resume-review', [StudentResumeController::class, 'review'])->name('student.resume-review');
    Route::post('/resume-review/ai', [StudentResumeController::class, 'requestAiReview'])->name('student.resume-review.ai');
    Route::get('/skills', [SkillController::class, 'index'])->name('student.skills');
    Route::post('/skills', [SkillController::class, 'store'])->name('student.skills.store');
    Route::put('/skills/{skill}', [SkillController::class, 'update'])->name('student.skills.update');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('student.skills.destroy');
    Route::get('/jobs', [StudentJobController::class, 'index'])->name('student.jobs');
    Route::get('/jobs/{job}', [StudentJobController::class, 'show'])->name('student.jobs.show');
    Route::get('/jobs/{job}/apply', [StudentJobController::class, 'showApplyForm'])->name('student.jobs.apply.form')->middleware('resume.uploaded');
    Route::post('/jobs/{job}/apply', [StudentJobController::class, 'apply'])->name('student.jobs.apply')->middleware('resume.uploaded');
    Route::get('/jobs/{job}/apply/success', [StudentJobController::class, 'applySuccess'])->name('student.jobs.apply.success');
    Route::post('/jobs/{job}/bookmark', [StudentJobController::class, 'bookmark'])->name('student.jobs.bookmark');
    Route::get('/applications', [StudentJobController::class, 'applications'])->name('student.applications');
    Route::post('/applications/{application}/withdraw', [StudentJobController::class, 'withdraw'])->name('student.applications.withdraw');
    Route::get('/interviews', [InterviewController::class, 'studentIndex'])->name('student.interviews');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('student.notifications');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
    Route::get('/verification', [AdminController::class, 'verification'])->name('admin.verification');
    Route::post('/verification/{employer}/approve', [AdminController::class, 'approveEmployer'])->name('admin.verification.approve');
    Route::post('/verification/{employer}/reject', [AdminController::class, 'rejectEmployer'])->name('admin.verification.reject');
    Route::get('/jobs', [AdminController::class, 'jobs'])->name('admin.jobs');
    Route::post('/jobs/{job}/dismiss-report', [AdminController::class, 'dismissJobReport'])->name('admin.jobs.dismiss-report');
    Route::post('/jobs/{job}/remove', [AdminController::class, 'removeJob'])->name('admin.jobs.remove');
    Route::get('/taxonomy', [AdminController::class, 'taxonomy'])->name('admin.taxonomy');
    Route::post('/taxonomy/category', [AdminController::class, 'storeCategory'])->name('admin.taxonomy.category.store');
    Route::put('/taxonomy/category/{category}', [AdminController::class, 'updateCategory'])->name('admin.taxonomy.category.update');
    Route::delete('/taxonomy/category/{category}', [AdminController::class, 'destroyCategory'])->name('admin.taxonomy.category.destroy');
    Route::post('/taxonomy/skill', [AdminController::class, 'storeSkill'])->name('admin.taxonomy.skill.store');
    Route::put('/taxonomy/skill/{skill}', [AdminController::class, 'updateSkill'])->name('admin.taxonomy.skill.update');
    Route::delete('/taxonomy/skill/{skill}', [AdminController::class, 'destroySkill'])->name('admin.taxonomy.skill.destroy');
    Route::get('/resumes', [AdminController::class, 'resumes'])->name('admin.resumes');
    Route::get('/resumes/{resume}/download', [AdminController::class, 'downloadResume'])->name('admin.resumes.download');
    Route::post('/resumes/{resume}/review', [AdminController::class, 'reviewResume'])->name('admin.resumes.review');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/activity', [AdminController::class, 'activity'])->name('admin.activity');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings/toggle', [AdminController::class, 'toggleSetting'])->name('admin.settings.toggle');
    Route::post('/settings/run-close-expired-jobs', [AdminController::class, 'runCloseExpiredJobs'])->name('admin.settings.run-close-expired-jobs');
    Route::post('/settings/credentials', [AdminController::class, 'updateCredentials'])->name('admin.settings.updateCredentials');
});

require __DIR__.'/auth.php';