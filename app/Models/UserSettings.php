<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSettings extends Model
{
    protected $fillable = [
        'user_id',
        'notifications_enabled',
        'telegram_notifications_enabled',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
