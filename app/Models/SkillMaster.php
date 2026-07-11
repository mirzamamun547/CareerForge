<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillMaster extends Model
{
    use HasFactory;

    protected $table = 'skills_master';

    protected $fillable = ['name'];

    /**
     * Per-student skill rows linked to this master skill.
     */
    public function studentSkills(): HasMany
    {
        return $this->hasMany(Skill::class, 'skill_master_id');
    }

    /**
     * Job listings that require this skill.
     */
    public function jobListings(): BelongsToMany
    {
        return $this->belongsToMany(JobListing::class, 'job_listing_skill_master', 'skill_master_id', 'job_listing_id');
    }

    /**
     * Find an existing master skill by (case-insensitive) name, or create one.
     * Use this whenever a student adds a skill or an employer posts a job,
     * so free-text input always resolves to the same row (e.g. "laravel" ==
     * "Laravel").
     */
    public static function resolve(string $name): self
    {
        $name = trim($name);

        return static::query()->whereRaw('LOWER(name) = ?', [strtolower($name)])->first()
            ?? static::create(['name' => $name]);
    }
}