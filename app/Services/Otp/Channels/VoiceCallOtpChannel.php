<?php

namespace App\Services\Otp\Channels;

class VoiceCallOtpChannel implements OtpChannelInterface
{
    public function handle(string $clientUuid, string $mobile, int $code): void
    {
        // TODO: Implement handle() method.
    }
}
