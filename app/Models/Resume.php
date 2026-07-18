<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_profile_id',
        'file_path',
        'status',
    ];

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ResumeReview::class);
    }

    public function latestReview(): HasOne
    {
        return $this->hasOne(ResumeReview::class)->latestOfMany('reviewed_at');
    }

    public function aiReview(): HasOne
    {
        return $this->hasOne(ResumeReview::class)->where('source', 'ai')->latestOfMany('reviewed_at');
    }

    public function manualReview(): HasOne
    {
        return $this->hasOne(ResumeReview::class)->where('source', 'manual')->latestOfMany('reviewed_at');
    }
}