<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryOption extends Model
{
    /** @use HasFactory<\Database\Factories\DeliveryOptionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nova_post',
        'ukr_post',
        'meest',
    ];

    protected $casts = [
      'nova_post' => 'boolean',
      'ukr_post' => 'boolean',
      'meest' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
