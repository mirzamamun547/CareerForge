<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResumeReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'reviewed_by',
        'source',
        'overall_score',
        'feedback',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'overall_score' => 'integer',
            'reviewed_at' => 'datetime',
        ];
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(Resume::class);
    }

    /**
     * The admin/employer user who wrote this review.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}