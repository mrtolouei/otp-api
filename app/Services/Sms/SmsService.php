<?php

namespace App\Services\Sms;

use App\Factories\SmsProviderFactory;

class SmsService
{
    public function __construct(protected SmsProviderFactory $factory)
    {
        //
    }

    public function send(string $mobile, string $message): bool
    {
        return $this->factory->make()->send($mobile, $message);
    }
}
