<?php

namespace App\Factories;

use App\Services\Sms\Providers\MockSmsProvider;
use App\Services\Sms\Providers\SmsProviderInterface;
use InvalidArgumentException;

class SmsProviderFactory
{
    public function make(): SmsProviderInterface
    {
        $provider = config('sms.default', 'mock');
        return match ($provider) {
            'mock' => app(MockSmsProvider::class),
            default => throw new InvalidArgumentException("Invalid SMS provider: $provider")
        };
    }
}
