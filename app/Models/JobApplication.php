<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'job_listing_id',
        'status',
        'cover_letter',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }

    public function interview(): HasOne
    {
        return $this->hasOne(Interview::class);
    }
}
