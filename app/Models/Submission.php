<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Submission extends Model
{
    protected $fillable = [
        'submission_number',
        'user_id',
        'letter_type_id',
        'reviewed_by',
        'purpose',
        'status',
        'admin_note',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function letterType(): BelongsTo
    {
        return $this->belongsTo(LetterType::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(SubmissionDocument::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(SubmissionHistory::class);
    }
}