<?php

namespace App\Services\Sms\Providers;

interface SmsProviderInterface
{
    public function send(string $mobile, string $message): bool;
}
