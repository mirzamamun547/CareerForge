<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'profile_picture',
        'status',
        'verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verified' => 'boolean',
        ];
    }

    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function employerProfile(): HasOne
    {
        return $this->hasOne(EmployerProfile::class);
    }

    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }

    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'student_id');
    }

    public function jobBookmarks(): HasMany
    {
        return $this->hasMany(JobBookmark::class, 'student_id');
    }

    public function skills(): HasManyThrough
    {
        return $this->hasManyThrough(Skill::class, StudentProfile::class);
    }

    /**
     * Resume reviews this user (admin/employer) has written.
     */
    public function resumeReviewsWritten(): HasMany
    {
        return $this->hasMany(ResumeReview::class, 'reviewed_by');
    }

    public function interviewsAsEmployer(): HasMany
    {
        return $this->hasMany(Interview::class, 'employer_id');
    }

    public function interviewsAsStudent(): HasMany
    {
        return $this->hasMany(Interview::class, 'student_id');
    }

    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    public function isEmployer(): bool
    {
        return $this->role === 'employer';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Where this user should land after login, based on role.
     */
    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'student' => route('student.dashboard'),
            'employer' => route('employer.dashboard'),
            'admin' => route('admin.dashboard'),
            default => route('dashboard'),
        };
    }
}