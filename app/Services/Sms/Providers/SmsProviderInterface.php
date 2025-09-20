<?php

namespace App\Services\Sms\Providers;

use App\Dto\SmsSentResult;

interface SmsProviderInterface
{
    public function send(string $mobile, string $message): SmsSentResult;
}
