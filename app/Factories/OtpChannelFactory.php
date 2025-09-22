<?php

namespace App\Factories;

use App\Enums\OtpChannelsEnum;
use App\Services\Otp\Channels\OtpChannelInterface;
use App\Services\Otp\Channels\SmsOtpChannel;
use InvalidArgumentException;

class OtpChannelFactory
{
    public function make(string $channel): OtpChannelInterface
    {
        return match($channel) {
            OtpChannelsEnum::SMS->name => app(SmsOtpChannel::class),
            default => throw new InvalidArgumentException(__("Unsupported OTP channel: $channel")),
        };
    }
}
