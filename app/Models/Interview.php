<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'employer_id',
        'student_id',
        'scheduled_at',
        'type',
        'location',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function jobApplication(): BelongsTo
    {
        return $this->belongsTo(JobApplication::class);
    }

    public function employer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', 'scheduled')
                     ->where('scheduled_at', '>=', now());
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->where('status', '!=', 'scheduled')
              ->orWhere('scheduled_at', '<', now());
        });
    }
}
