<?php

namespace App\Services\Otp\Channels;

interface OtpChannelInterface
{
    public function handle(int $clientTokenId, string $mobile, int $code): void;
}
