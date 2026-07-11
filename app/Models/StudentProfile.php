<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'profile_picture',
        'university',
        'department',
        'graduation_year',
    ];

    protected function casts(): array
    {
        return [
            'graduation_year' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resumes(): HasMany
    {
        return $this->hasMany(Resume::class);
    }

    public function latestResume(): HasOne
    {
        return $this->hasOne(Resume::class)->latestOfMany();
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    /**
     * Distinct skills_master IDs this student has (used for job matching).
     */
    public function skillMasterIds()
    {
        return $this->skills()->whereNotNull('skill_master_id')->pluck('skill_master_id')->unique()->values();
    }
}