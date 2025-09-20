<?php

namespace App\Services\Otp\Channels;

interface OtpChannelInterface
{
    public function handle(string $clientUuid, string $mobile, int $code): void;
}
