<?php

namespace App;

use Illuminate\Support\Str;

class LogFacade
{
    private static $fingerprint;

    public static function info(string $message, array $context = [])
    {
        $fingerprint = null;
        try {
            if (!isset(self::$fingerprint)) {
                self::$fingerprint = request()->fingerprint() . Str::random(8);
            }
        } catch (\Exception $e) {
            self::$fingerprint = 'Route unavailable';
        }

        \Illuminate\Support\Facades\Log::info($message, ['requestId' => self::$fingerprint] + $context);
    }
}