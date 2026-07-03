<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

        // Student fields
        'university',
        'department',
        'graduation_year',

        // Employer fields
        'company_name',
        'company_email',
        'website',
        'industry',
        'company_address',
        'contact_person',
        'company_logo',
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
            'graduation_year' => 'integer',
        ];
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
            'admin' => route('dashboard'),
            default => route('dashboard'),
        };
    }
}
