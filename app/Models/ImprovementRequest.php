<?php

namespace App\Models;

use App\Enums\ImprovementRequestStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImprovementRequest extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'status'];

    protected $casts = [
        'status' => ImprovementRequestStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
