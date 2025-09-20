<?php

namespace App\Services\Sms\Providers;

use App\Dto\SmsSentResult;

class MockSmsProvider implements SmsProviderInterface
{
    public function send(string $mobile, string $message): SmsSentResult
    {
        logger()->info('SMS Sent successfully', [
            'mobile' => $mobile,
            'message' => $message,
        ]);
        return new SmsSentResult(
            ok: true
        );
    }
}
