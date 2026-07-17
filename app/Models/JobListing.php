<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'job_type',
        'location',
        'city',
        'country',
        'latitude',
        'longitude',
        'level',
        'min_salary',
        'max_salary',
        'deadline',
        'skills',
        'description',
        'requirements',
        'benefits',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function bookmarks(): HasMany
    {
        return $this->hasMany(JobBookmark::class);
    }

    /**
     * The structured, matchable required skills for this job.
     */
    public function skillMasters(): BelongsToMany
    {
        return $this->belongsToMany(SkillMaster::class, 'job_listing_skill_master', 'job_listing_id', 'skill_master_id');
    }

    /**
     * Parse the free-text `skills` field, resolve each name against
     * skills_master, and sync the pivot table. Call this after
     * creating/updating a job listing.
     */
    public function syncSkillsFromText(): void
    {
        $names = array_filter(array_map('trim', explode(',', (string) $this->skills)));

        $masterIds = collect($names)->map(fn ($name) => SkillMaster::resolve($name)->id);

        $this->skillMasters()->sync($masterIds);
    }
}