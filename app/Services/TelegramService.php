<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    public static function send(string $message)
    {
        try {
            $response = Http::post(
                'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage',
                [
                    'chat_id' => env('TELEGRAM_CHAT_ID'),
                    'text' => $message,
                    'parse_mode' => 'HTML'
                ]
            );

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Telegram Send Failed: ' . $e->getMessage());

            return false;
        }
    }
}