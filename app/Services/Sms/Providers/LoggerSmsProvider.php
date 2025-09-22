<?php

namespace App\Services\Sms\Providers;

class LoggerSmsProvider implements SmsProviderInterface
{
    public function send(string $mobile, string $message): bool
    {
        logger()->info('SMS Sent successfully', [
            'mobile' => $mobile,
            'message' => $message,
        ]);
        return true;
    }
}
