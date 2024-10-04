<?php

namespace App\Models;

use App\Http\Controllers\TelegramNotificationController;
use App\Notifications\TelegramNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\Util\Str;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'contacts',
        'note'
    ];

    protected $casts = [
        'contacts' => 'string',
        'note' => 'string',
    ];
}
