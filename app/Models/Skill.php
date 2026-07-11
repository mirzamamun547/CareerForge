<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_profile_id',
        'skill_master_id',
        'name',
        'level',
        'proficiency',
    ];

    protected function casts(): array
    {
        return [
            'proficiency' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        // Whenever a student adds/renames a skill, resolve it to the master
        // skills_master row automatically, so matching queries always have
        // something to join on without any extra code in the controller.
        static::saving(function (Skill $skill) {
            if ($skill->name && ($skill->isDirty('name') || !$skill->skill_master_id)) {
                $skill->skill_master_id = SkillMaster::resolve($skill->name)->id;
            }
        });
    }

    public function studentProfile(): BelongsTo
    {
        return $this->belongsTo(StudentProfile::class);
    }

    public function skillMaster(): BelongsTo
    {
        return $this->belongsTo(SkillMaster::class, 'skill_master_id');
    }
}