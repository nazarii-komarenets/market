<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TelegramNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class TelegramNotificationController extends Controller
{
    /**
     * Create a unique code for the user to activate Telegram notifications.
     *
     * @param Request $request
     * @return \\Illuminate\\Http\\JsonResponse
     */
    public function create(Request $request)
    {
        $telegramBotUrl = config('services.telegram-bot-api.bot_url');

        $userTempCode = Str::random(35);
        Cache::store('telegram')
            ->put($userTempCode, \auth()->id(), $seconds = 120);

        // Telegram URL:
        // <https://t.me/ExampleBot?start=vCH1vGWJxfSeofSAs0K5PA>
        $telegramUrl = $telegramBotUrl . '?start=' . $userTempCode;

        return Redirect::to($telegramUrl);

    }

    /**
     * Store Telegram Chat ID from telegram webhook message.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $messageText = $request->message['text'];
        } catch (Exception $e) {
            return response()->json([
                'code'     => $e->getCode(),
                'message'  => 'Accepted with error: \'' . $e->getMessage() . '\'',
            ], 202);
        }
        // Check if the message matches the expected pattern.
        if (!Str::of($messageText)->test('/^\/start\s[A-Za-z0-9]{35}$/')) {
            return response('Accepted', 202);
        }

        // Cleanup the string
        $userTempCode = Str::of($messageText)->remove('/start ');

        // Get the User ID from the cache using the temp code as key.
        $userId = Cache::store('telegram')->pull((string)$userTempCode);

        if ($userId) {
            $user = User::find((int)$userId);

            // Get Telegram ID from the request.
            $chatId = $request->message['chat']['id'];

            // Update user with the Telegram Chat ID
            $user->telegram_chat_id = $chatId;
            $user->save();

            return response('Success', 200);
        }
    }
}
