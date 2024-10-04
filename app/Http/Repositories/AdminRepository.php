<?php

namespace App\Http\Repositories;

use App\Models\User;

class AdminRepository
{
    public function getAdminsWithTelegram()
    {
        return User::where('is_admin', 1)
            ->whereNotNull('telegram_chat_id')
            ->get();
    }
}
