<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_email',
        'website',
        'industry',
        'company_address',
        'contact_person',
        'company_logo',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
