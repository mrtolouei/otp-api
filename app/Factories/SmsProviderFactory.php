<?php

namespace App\Factories;

use App\Services\Sms\Providers\LoggerSmsProvider;
use App\Services\Sms\Providers\SmsProviderInterface;
use InvalidArgumentException;

class SmsProviderFactory
{
    public function make(): SmsProviderInterface
    {
        $provider = config('sms.default', 'logger');
        return match($provider) {
            'logger' => app(LoggerSmsProvider::class),
            default => throw new InvalidArgumentException(__("Unsupported SMS provider: $provider")),
        };
    }
}
